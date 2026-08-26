<?php

namespace Database\Factories;

use App\Enums\TagName;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    protected $model = Tag::class;

    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement(TagName::cases()),
        ];
    }
}
