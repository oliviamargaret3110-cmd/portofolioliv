<?php

namespace Tests\Feature;

use App\Models\Message;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminPortfolioTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->admin()->create();
    }

    public function test_admin_dapat_menambah_proyek(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.projects.store'), [
                'title' => 'Website Sekolah',
                'category' => 'Website',
                'short_description' => 'Website profil sekolah.',
                'technologies' => 'Laravel, MySQL',
                'is_featured' => '1',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('projects', [
            'title' => 'Website Sekolah',
            'slug' => 'website-sekolah',
            'is_featured' => true,
            'thumbnail' => null,
        ]);
    }

    public function test_admin_dapat_memperbarui_proyek(): void
    {
        $project = Project::factory()->create(['title' => 'Judul Lama', 'slug' => 'judul-lama']);

        $this->actingAs($this->admin)
            ->put(route('admin.projects.update', $project), [
                'title' => 'Judul Baru',
                'category' => 'Website',
                'short_description' => 'Deskripsi baru.',
            ])
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseHas('projects', [
            'id' => $project->id,
            'title' => 'Judul Baru',
            'slug' => 'judul-baru',
        ]);
    }

    public function test_admin_dapat_menghapus_proyek_beserta_gambarnya(): void
    {
        Storage::fake('public');

        $project = Project::factory()->create();
        $image = ProjectImage::factory()->create([
            'project_id' => $project->id,
            'image' => 'projects/contoh.jpg',
        ]);

        Storage::disk('public')->put($image->image, 'dummy');

        $this->actingAs($this->admin)
            ->delete(route('admin.projects.destroy', $project))
            ->assertRedirect(route('admin.projects.index'));

        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
        $this->assertDatabaseMissing('project_images', ['id' => $image->id]);
        Storage::disk('public')->assertMissing($image->image);
    }

    public function test_validasi_proyek_menolak_data_kosong(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.projects.store'), [])
            ->assertSessionHasErrors(['title', 'category', 'short_description']);
    }

    public function test_admin_dapat_mengunggah_gambar_dokumentasi_proyek(): void
    {
        Storage::fake('public');

        $project = Project::factory()->create();

        $this->actingAs($this->admin)
            ->post(route('admin.projects.images.store', $project), [
                'image' => UploadedFile::fake()->image('dokumentasi.jpg'),
                'caption' => 'Halaman dashboard',
                'sort_order' => 1,
            ])
            ->assertRedirect(route('admin.projects.show', $project));

        $image = ProjectImage::query()->firstOrFail();

        $this->assertSame('Halaman dashboard', $image->caption);
        Storage::disk('public')->assertExists($image->image);
    }

    public function test_admin_dapat_mengelola_keahlian(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.skills.store'), [
                'name' => 'Laravel',
                'category' => 'hard',
                'percentage' => 90,
                'icon' => 'fa-brands fa-laravel',
                'sort_order' => 1,
            ])
            ->assertRedirect(route('admin.skills.index'));

        $skill = Skill::query()->where('name', 'Laravel')->firstOrFail();

        $this->actingAs($this->admin)
            ->put(route('admin.skills.update', $skill), [
                'name' => 'Laravel Framework',
                'category' => 'hard',
                'percentage' => 95,
            ])
            ->assertRedirect(route('admin.skills.index'));

        $this->assertDatabaseHas('skills', ['id' => $skill->id, 'percentage' => 95]);

        $this->actingAs($this->admin)
            ->delete(route('admin.skills.destroy', $skill))
            ->assertRedirect(route('admin.skills.index'));

        $this->assertDatabaseMissing('skills', ['id' => $skill->id]);
    }

    public function test_validasi_keahlian_menolak_persentase_lebih_dari_seratus(): void
    {
        $this->actingAs($this->admin)
            ->post(route('admin.skills.store'), [
                'name' => 'Tes',
                'category' => 'hard',
                'percentage' => 150,
            ])
            ->assertSessionHasErrors('percentage');
    }

    public function test_admin_dapat_memperbarui_profil_dan_akun(): void
    {
        $profile = Profile::factory()->create(['user_id' => $this->admin->id]);

        $this->actingAs($this->admin)
            ->put(route('admin.profile.update'), [
                'full_name' => 'Nama Baru',
                'headline' => 'Web Developer',
                'email' => 'publik@example.com',
                'account_name' => 'Admin Baru',
                'account_email' => 'admin-baru@example.com',
            ])
            ->assertRedirect(route('admin.profile.edit'));

        $this->assertDatabaseHas('profiles', [
            'id' => $profile->id,
            'full_name' => 'Nama Baru',
        ]);

        $this->assertDatabaseHas('users', [
            'id' => $this->admin->id,
            'name' => 'Admin Baru',
            'email' => 'admin-baru@example.com',
        ]);
    }

    public function test_admin_dapat_menyimpan_pengaturan_website(): void
    {
        $this->actingAs($this->admin)
            ->put(route('admin.settings.update'), [
                'site_name' => 'Portofolio Uji',
                'site_tagline' => 'Tagline Uji',
                'site_description' => 'Deskripsi uji.',
                'footer_text' => 'Footer uji.',
                'availability_text' => 'Terbuka',
            ])
            ->assertRedirect(route('admin.settings.edit'));

        $this->assertSame('Portofolio Uji', Setting::get('site_name'));
        $this->assertSame('Tagline Uji', Setting::get('site_tagline'));
    }

    public function test_admin_dapat_menandai_pesan_dibaca_dan_menghapusnya(): void
    {
        $message = Message::factory()->create(['is_read' => false]);

        $this->actingAs($this->admin)
            ->patch(route('admin.messages.read', $message))
            ->assertRedirect();

        $this->assertTrue($message->fresh()->is_read);

        $this->actingAs($this->admin)
            ->delete(route('admin.messages.destroy', $message))
            ->assertRedirect(route('admin.messages.index'));

        $this->assertDatabaseMissing('messages', ['id' => $message->id]);
    }
}
