<?php

namespace Database\Factories;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(4),
            'organization' => fake()->company(),
            'position' => fake()->jobTitle(),
            'type' => fake()->randomElement(array_keys(Experience::TYPES)),
            'start_date' => fake()->date(),
            'end_date' => null,
            'is_current' => false,
            'description' => fake()->paragraph(),
            'image' => 'seed/placeholder.svg',
            'sort_order' => 0,
        ];
    }
}
