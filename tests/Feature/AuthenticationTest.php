<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_halaman_login_dapat_diakses(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Login Admin');
    }

    public function test_admin_dapat_login(): void
    {
        $admin = User::factory()->admin()->create();

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($admin);
    }

    public function test_superadmin_dapat_login_ke_dashboard(): void
    {
        $superadmin = User::factory()->superadmin()->create();

        $this->post(route('login.store'), [
            'email' => $superadmin->email,
            'password' => 'password',
        ])->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($superadmin);
    }

    public function test_login_gagal_dengan_password_salah(): void
    {
        $admin = User::factory()->admin()->create();

        $this->from(route('login'))->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password-salah',
        ])->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_pengguna_bukan_admin_tidak_bisa_membuka_dashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('admin.dashboard'))
            ->assertForbidden();
    }

    public function test_admin_dapat_logout(): void
    {
        $admin = User::factory()->admin()->create();

        $this->actingAs($admin)
            ->post(route('logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }
}
