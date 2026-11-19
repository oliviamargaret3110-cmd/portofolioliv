<?php

namespace Database\Factories;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Profile>
 */
class ProfileFactory extends Factory
{
    protected $model = Profile::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'full_name' => fake()->name(),
            'headline' => 'Web Developer & PPLG Student',
            'photo' => 'seed/avatar.svg',
            'class_name' => 'XII PPLG 1',
            'major' => 'Pengembangan Perangkat Lunak dan Gim',
            'bio' => fake()->paragraph(),
            'career_goal' => fake()->paragraph(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'location' => fake()->city(),
            'github_url' => 'https://github.com/example',
            'instagram_url' => 'https://instagram.com/example',
            'linkedin_url' => 'https://linkedin.com/in/example',
        ];
    }
}
