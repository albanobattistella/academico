<?php

namespace Database\Factories;

use App\Models\SchedulePreset;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SchedulePreset>
 */
class SchedulePresetFactory extends Factory
{
    protected $model = SchedulePreset::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->word(),
            'presets' => fake()->sentence(),
        ];
    }
}
