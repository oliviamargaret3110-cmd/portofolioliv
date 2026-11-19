<?php

namespace Database\Factories;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Certificate>
 */
class CertificateFactory extends Factory
{
    protected $model = Certificate::class;

    public function definition(): array
    {
        return [
            'title' => fake()->unique()->sentence(4),
            'organizer' => fake()->company(),
            'date' => fake()->date(),
            'description' => fake()->sentence(10),
            'image' => 'seed/placeholder.svg',
            'category' => fake()->randomElement(array_keys(Certificate::CATEGORIES)),
            'sort_order' => 0,
        ];
    }
}
