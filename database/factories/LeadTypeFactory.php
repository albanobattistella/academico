<?php

namespace Database\Factories;

use App\Models\LeadType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<LeadType>
 */
class LeadTypeFactory extends Factory
{
    protected $model = LeadType::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
        ];
    }
}
