<?php

namespace Tests\Feature\Database\Seeders;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use RuntimeException;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeding_outside_local_and_testing_requires_admin_password(): void
    {
        $this->app->detectEnvironment(fn (): string => 'production');

        config([
            'auth.portfolio_admin_seed_password' => null,
        ]);

        try {
            app(DatabaseSeeder::class)->run();
        } catch (RuntimeException $exception) {
            $this->assertSame(
                'PORTFOLIO_ADMIN_SEED_PASSWORD must be set before seeding outside local/testing.',
                $exception->getMessage()
            );
            $this->assertDatabaseCount('users', 0);

            return;
        }

        $this->fail('Seeding should require a configured admin password.');
    }

    public function test_seeding_uses_the_configured_admin_password(): void
    {
        $seedPassword = 'generated-production-password';

        $this->app->detectEnvironment(fn (): string => 'production');

        config([
            'auth.portfolio_admin_seed_password' => $seedPassword,
        ]);

        app(DatabaseSeeder::class)->run();

        $admin = User::query()->where('email', 'admin@portfolio.test')->firstOrFail();

        $this->assertTrue(Hash::check($seedPassword, $admin->password));
        $this->assertDatabaseHas('profiles', ['full_name' => 'Olivia Margaret']);
    }

    public function test_seeding_replaces_an_existing_default_admin_password(): void
    {
        $admin = User::factory()->create([
            'email' => 'admin@portfolio.test',
            'password' => Hash::make('password'),
        ]);
        $seedPassword = 'generated-production-password';

        $this->app->detectEnvironment(fn (): string => 'production');

        config([
            'auth.portfolio_admin_seed_password' => $seedPassword,
        ]);

        app(DatabaseSeeder::class)->run();

        $this->assertTrue(Hash::check($seedPassword, $admin->fresh()->password));
    }
}
