<?php

namespace Database\Factories;

use App\Models\BlogPost;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence(5);

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.fake()->unique()->numberBetween(1, 99999),
            'category' => 'Catatan Ngoding',
            'image' => 'seed/placeholder.svg',
            'excerpt' => fake()->sentence(15),
            'content' => fake()->paragraphs(5, true),
            'published_at' => now(),
        ];
    }
}
