<?php

namespace Tests\Unit;

use App\Models\Course;
use App\Models\CourseTime;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTimeTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_course_time(): void
    {
        $courseTime = CourseTime::factory()->create();

        $this->assertDatabaseHas('course_times', ['id' => $courseTime->id]);
    }

    public function test_course_time_belongs_to_course(): void
    {
        $courseTime = CourseTime::factory()->create();

        $this->assertInstanceOf(Course::class, $courseTime->course);
    }
}
