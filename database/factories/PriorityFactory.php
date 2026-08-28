<?php

namespace Database\Factories;

use App\Enums\PriorityLevel;
use App\Models\Priority;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Priority>
 */
class PriorityFactory extends Factory
{
    protected $model = Priority::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(PriorityLevel::cases()),
        ];
    }
}
