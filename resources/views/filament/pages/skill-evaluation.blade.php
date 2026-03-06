<x-filament-panels::page>
    <div class="mb-4">
        <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ $courseName }}</h2>
    </div>

    @if($selectedEnrollmentId)
        {{-- Student Detail View --}}
        @php
            $currentIndex = $this->getCurrentStudentIndex();
            $currentStudent = $enrollments[$currentIndex] ?? null;
            $totalStudents = count($enrollments);
        @endphp

        <div class="flex items-center justify-between mb-6 rounded-lg border border-gray-200 bg-white p-3 dark:border-gray-700 dark:bg-gray-800">
            <x-filament::button
                wire:click="previousStudent"
                size="sm"
                color="gray"
                icon="heroicon-o-chevron-left"
                :disabled="$currentIndex === 0"
            >
                {{ __('Previous') }}
            </x-filament::button>

            <div class="text-center">
                <p class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ $currentStudent['studentName'] ?? '' }}
                </p>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    {{ ($currentIndex + 1) }} / {{ $totalStudents }}
                </p>
            </div>

            <x-filament::button
                wire:click="nextStudent"
                size="sm"
                color="gray"
                icon-position="after"
                icon="heroicon-o-chevron-right"
                :disabled="$currentIndex === $totalStudents - 1"
            >
                {{ __('Next') }}
            </x-filament::button>
        </div>

        <div class="mb-4">
            <x-filament::button
                wire:click="backToOverview"
                size="sm"
                color="gray"
                icon="heroicon-o-arrow-left"
            >
                {{ __('Back to overview') }}
            </x-filament::button>
        </div>

        @if(count($skills) > 0)
            <x-filament::section>
                <x-slot name="heading">{{ __('Skills') }}</x-slot>

                <div class="space-y-4">
                    @foreach($skills as $skill)
                        <div class="flex flex-col gap-2 rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800 sm:flex-row sm:items-center sm:justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">
                                    {{ $skill['name'] }}
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $skill['typeName'] }} · {{ $skill['levelName'] }}
                                </p>
                            </div>
                            <div class="inline-flex rounded-md shadow-sm">
                                @foreach($scales as $i => $scale)
                                    @php
                                        $isActive = ($evaluations[$skill['id']] ?? null) === $scale['id'];
                                        $color = $scale['color'] ?? '#9ca3af';
                                    @endphp
                                    <button
                                        wire:click="setEvaluation({{ $skill['id'] }}, {{ $scale['id'] }})"
                                        class="px-2.5 py-1.5 text-xs font-medium transition-colors border {{ $i === 0 ? 'rounded-l-md' : '' }} {{ $i === count($scales) - 1 ? 'rounded-r-md' : '' }} {{ $i > 0 ? '-ml-px' : '' }} {{ $isActive ? 'z-10' : '' }}"
                                        style="{{ $isActive
                                            ? 'background-color: ' . $color . '; color: white; border-color: ' . $color . ';'
                                            : 'background-color: transparent; color: ' . $color . '; border-color: ' . $color . '40;'
                                        }}"
                                    >
                                        {{ $scale['shortname'] ?? $scale['name'] }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </x-filament::section>
        @else
            <x-filament::section>
                <p class="text-sm text-gray-500">{{ __('No skills configured for this course.') }}</p>
            </x-filament::section>
        @endif
    @else
        {{-- Overview Matrix --}}
        @if(count($enrollments) === 0)
            <x-filament::section>
                <p class="text-sm text-gray-500">{{ __('No students enrolled in this course.') }}</p>
            </x-filament::section>
        @elseif(count($skills) === 0)
            <x-filament::section>
                <p class="text-sm text-gray-500">{{ __('No skills configured for this course.') }}</p>
            </x-filament::section>
        @else
            <x-filament::section>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead>
                            <tr>
                                <th class="sticky left-0 z-10 bg-gray-50 dark:bg-gray-800 px-3 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                                    {{ __('Skill') }}
                                </th>
                                @foreach($enrollments as $enrollment)
                                    <th class="px-2 py-2 text-center text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider whitespace-nowrap">
                                        <button
                                            wire:click="selectStudent({{ $enrollment['id'] }})"
                                            class="hover:text-primary-600 dark:hover:text-primary-400 hover:underline"
                                        >
                                            {{ $enrollment['studentName'] }}
                                        </button>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            @php $currentType = null; @endphp
                            @foreach($skills as $skill)
                                @if($skill['typeName'] !== $currentType)
                                    @php $currentType = $skill['typeName']; @endphp
                                    @if($currentType)
                                        <tr>
                                            <td
                                                colspan="{{ count($enrollments) + 1 }}"
                                                class="sticky left-0 bg-gray-100 dark:bg-gray-900 px-3 py-2 text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase"
                                            >
                                                {{ $currentType }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                    <td class="sticky left-0 z-10 bg-white dark:bg-gray-900 px-3 py-2 text-sm text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $skill['name'] }}
                                        @if($skill['levelName'])
                                            <span class="text-xs text-gray-400">({{ $skill['levelName'] }})</span>
                                        @endif
                                    </td>
                                    @foreach($enrollments as $enrollment)
                                        @php
                                            $key = $enrollment['id'] . '-' . $skill['id'];
                                            $currentScaleId = $allEvaluations[$key] ?? null;
                                            $currentScale = $currentScaleId ? collect($scales)->firstWhere('id', $currentScaleId) : null;
                                        @endphp
                                        <td class="px-2 py-2 text-center">
                                            <div class="inline-flex rounded-md shadow-sm">
                                                @foreach($scales as $i => $scale)
                                                    @php
                                                        $isActive = ($allEvaluations[$key] ?? null) === $scale['id'];
                                                        $color = $scale['color'] ?? '#9ca3af';
                                                    @endphp
                                                    <button
                                                        wire:click="setEvaluationFromMatrix({{ $enrollment['id'] }}, {{ $skill['id'] }}, {{ $scale['id'] }})"
                                                        class="px-2 py-1 text-xs font-medium transition-colors border {{ $i === 0 ? 'rounded-l-md' : '' }} {{ $i === count($scales) - 1 ? 'rounded-r-md' : '' }} {{ $i > 0 ? '-ml-px' : '' }} {{ $isActive ? 'z-10' : '' }}"
                                                        style="{{ $isActive
                                                            ? 'background-color: ' . $color . '; color: white; border-color: ' . $color . ';'
                                                            : 'background-color: transparent; color: ' . $color . '; border-color: ' . $color . '40;'
                                                        }}"
                                                    >
                                                        {{ $scale['shortname'] ?? $scale['name'] }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </x-filament::section>
        @endif
    @endif
</x-filament-panels::page>
