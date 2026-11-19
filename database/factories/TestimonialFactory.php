<?php

namespace Database\Factories;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Testimonial>
 */
class TestimonialFactory extends Factory
{
    protected $model = Testimonial::class;

    public function definition(): array
    {
        return [
            'project_id' => null,
            'name' => fake()->name(),
            'position' => fake()->jobTitle(),
            'category' => fake()->randomElement(array_keys(Testimonial::CATEGORIES)),
            'content' => fake()->paragraph(),
            'photo' => null,
            'sort_order' => 0,
        ];
    }
}
