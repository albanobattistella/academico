<?php

namespace App\Filament\Pages;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Skills\SkillEvaluation;
use App\Models\Skills\SkillScale;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SkillEvaluationPage extends Page
{
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-star';

    protected static ?int $navigationSort = 2;

    public static function canAccess(): bool
    {
        return auth()->user()?->can('evaluation.view') ?? false;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    protected string $view = 'filament.pages.skill-evaluation';

    public int $courseId;

    public string $courseName = '';

    public ?int $selectedEnrollmentId = null;

    /** @var array<int, array<string, mixed>> */
    public array $enrollments = [];

    /** @var array<int, array<string, mixed>> */
    public array $skills = [];

    /** @var array<int, array<string, mixed>> */
    public array $scales = [];

    /** @var array<int, int|null> */
    public array $evaluations = [];

    /** @var array<string, int|null> Matrix: "enrollmentId-skillId" => scaleId */
    public array $allEvaluations = [];

    public function mount(): void
    {
        $courseId = request()->integer('courseId') ?: null;
        $course = $courseId ? Course::find($courseId) : null;

        abort_unless($course, 404);

        $this->courseId = $course->id;
        $this->courseName = $course->name;

        $this->scales = SkillScale::orderBy('value')->get()
            ->map(fn ($s) => [
                'id' => $s->id,
                'name' => $s->name,
                'shortname' => $s->shortname,
                'value' => $s->value,
                'color' => $s->color,
            ])
            ->toArray();

        $this->loadEnrollments();
        $this->loadSkills();
        $this->loadAllEvaluations();
    }

    protected function loadEnrollments(): void
    {
        $this->enrollments = Enrollment::with('student')
            ->where('course_id', $this->courseId)
            ->whereDoesntHave('childrenEnrollments')
            ->get()
            ->sortBy(fn ($e) => $e->student?->name)
            ->map(fn ($e) => [
                'id' => $e->id,
                'studentName' => $e->student?->name ?? '',
            ])
            ->values()
            ->toArray();
    }

    protected function loadSkills(): void
    {
        $course = Course::find($this->courseId);
        $courseSkills = $course?->skills()?->get() ?? collect();

        $this->skills = $courseSkills->map(fn ($skill) => [
            'id' => $skill->id,
            'name' => $skill->name,
            'typeName' => $skill->skillType?->name ?? '',
            'levelName' => $skill->level?->name ?? '',
        ])->toArray();
    }

    protected function loadAllEvaluations(): void
    {
        $enrollmentIds = collect($this->enrollments)->pluck('id');
        $skillIds = collect($this->skills)->pluck('id');

        $evals = SkillEvaluation::whereIn('enrollment_id', $enrollmentIds)
            ->whereIn('skill_id', $skillIds)
            ->get();

        $matrix = [];
        foreach ($evals as $eval) {
            $matrix[$eval->enrollment_id.'-'.$eval->skill_id] = $eval->skill_scale_id;
        }

        $this->allEvaluations = $matrix;
    }

    protected function loadSkillsAndEvaluations(): void
    {
        if (! $this->selectedEnrollmentId) {
            return;
        }

        $skillIds = collect($this->skills)->pluck('id');

        $existingEvals = SkillEvaluation::where('enrollment_id', $this->selectedEnrollmentId)
            ->whereIn('skill_id', $skillIds)
            ->get()
            ->keyBy('skill_id');

        $evals = [];
        foreach ($this->skills as $skill) {
            $eval = $existingEvals->get($skill['id']);
            $evals[$skill['id']] = $eval?->skill_scale_id;
        }

        $this->evaluations = $evals;
    }

    public function selectStudent(int $enrollmentId): void
    {
        $this->selectedEnrollmentId = $enrollmentId;
        $this->loadSkillsAndEvaluations();
    }

    public function backToOverview(): void
    {
        $this->selectedEnrollmentId = null;
        $this->evaluations = [];
        $this->loadAllEvaluations();
    }

    public function nextStudent(): void
    {
        $index = $this->getCurrentStudentIndex();
        if ($index !== null && $index < count($this->enrollments) - 1) {
            $this->selectStudent($this->enrollments[$index + 1]['id']);
        }
    }

    public function previousStudent(): void
    {
        $index = $this->getCurrentStudentIndex();
        if ($index !== null && $index > 0) {
            $this->selectStudent($this->enrollments[$index - 1]['id']);
        }
    }

    public function getCurrentStudentIndex(): ?int
    {
        if (! $this->selectedEnrollmentId) {
            return null;
        }

        foreach ($this->enrollments as $i => $enrollment) {
            if ($enrollment['id'] === $this->selectedEnrollmentId) {
                return $i;
            }
        }

        return null;
    }

    public function setEvaluation(int $skillId, int $scaleId): void
    {
        if (! $this->selectedEnrollmentId) {
            return;
        }

        SkillEvaluation::updateOrCreate(
            [
                'enrollment_id' => $this->selectedEnrollmentId,
                'skill_id' => $skillId,
            ],
            [
                'skill_scale_id' => $scaleId,
            ],
        );

        $this->evaluations[$skillId] = $scaleId;
        $this->allEvaluations[$this->selectedEnrollmentId.'-'.$skillId] = $scaleId;

        Notification::make()
            ->success()
            ->title(__('Skill evaluation saved'))
            ->duration(1500)
            ->send();
    }

    public function setEvaluationFromMatrix(int $enrollmentId, int $skillId, int $scaleId): void
    {
        SkillEvaluation::updateOrCreate(
            [
                'enrollment_id' => $enrollmentId,
                'skill_id' => $skillId,
            ],
            [
                'skill_scale_id' => $scaleId,
            ],
        );

        $this->allEvaluations[$enrollmentId.'-'.$skillId] = $scaleId;

        Notification::make()
            ->success()
            ->title(__('Skill evaluation saved'))
            ->duration(1500)
            ->send();
    }

    public static function getNavigationGroup(): ?string
    {
        return 'A revoir / WIP';
    }

    public static function getNavigationLabel(): string
    {
        return __('Skill Evaluation');
    }

    public function getTitle(): string|\Illuminate\Contracts\Support\Htmlable
    {
        return __('Skill Evaluation');
    }
}
