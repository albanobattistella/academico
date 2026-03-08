<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center justify-between">
                <span>{{ __('Period Information') }}</span>
                <x-filament::button size="sm" color="gray" icon="heroicon-m-pencil-square" :href="$this->getPeriodsUrl()" tag="a">
                    {{ __('Change') }}
                </x-filament::button>
            </div>
        </x-slot>

        @php
            $data = $this->getData();
        @endphp

        <div class="grid grid-cols-2 gap-6">
            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Current Period') }}</p>
                <p class="text-lg font-semibold">{{ $data['currentPeriod']?->name ?? '—' }}</p>
            </div>

            <div>
                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Enrollments Period') }}</p>
                <p class="text-lg font-semibold">{{ $data['enrollmentsPeriod']?->name ?? '—' }}</p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
