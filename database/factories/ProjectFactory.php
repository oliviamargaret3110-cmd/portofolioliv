<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    protected $model = Project::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(3);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'category' => fake()->randomElement(['Web App', 'Website', 'Desktop App']),
            'thumbnail' => 'seed/placeholder.svg',
            'short_description' => fake()->sentence(12),
            'description' => fake()->paragraphs(3, true),
            'problem' => fake()->sentence(10),
            'goal' => fake()->sentence(10),
            'technologies' => 'Laravel, MySQL, Tailwind CSS',
            'role' => 'Full Stack Developer',
            'features' => 'Login admin, CRUD data, laporan',
            'documentation' => fake()->paragraph(),
            'demo_url' => 'https://example.com',
            'github_url' => 'https://github.com/example/project',
            'is_featured' => false,
            'sort_order' => 0,
        ];
    }
}
