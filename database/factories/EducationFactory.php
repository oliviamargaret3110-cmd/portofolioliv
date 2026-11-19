<?php

namespace Database\Factories;

use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Education>
 */
class EducationFactory extends Factory
{
    protected $model = Education::class;

    public function definition(): array
    {
        return [
            'level' => fake()->randomElement(['SD', 'SMP', 'SMK']),
            'school_name' => 'SMK Negeri 1 Contoh',
            'major' => 'Pengembangan Perangkat Lunak dan Gim',
            'start_year' => '2021',
            'end_year' => '2024',
            'description' => fake()->sentence(),
            'sort_order' => 0,
        ];
    }
}
