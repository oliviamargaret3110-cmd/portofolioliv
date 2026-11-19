<?php

namespace Tests\Feature;

use App\Models\BlogPost;
use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_semua_halaman_publik_dapat_diakses(): void
    {
        $this->seed();

        $paths = [
            '/',
            '/about',
            '/skills',
            '/projects',
            '/certificates',
            '/experiences',
            '/testimonials',
            '/blog',
            '/contact',
            '/cv',
            '/cv/print',
        ];

        foreach ($paths as $path) {
            $this->get($path)->assertOk();
        }
    }

    public function test_cv_menampilkan_data_pendidikan_pengalaman_dan_kontak_terbaru(): void
    {
        $this->seed();

        foreach (['/cv', '/cv/print'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('Olivia Margaret')
                ->assertDontSee('Olivia Putri')
                ->assertSee('SMK Negeri 2 Banjarmasin')
                ->assertSee('SMP Negeri 13 Banjarmasin')
                ->assertSee('SD Negeri 2 Alalak')
                ->assertSee('Pengembangan Website SDIT Hunafa')
                ->assertSee('Pengembangan Website Logistik Rumah Sakit Islam')
                ->assertSee('SDIT Hunafa - Anggota Tim Belaset (PLK Kelas XI)')
                ->assertSee('27 Juli 2026')
                ->assertSee('27 November 2026')
                ->assertSee('olivimargaret3110@gmail.com')
                ->assertSee('@olvymrgt')
                ->assertDontSee('olivia.putri@example.com')
                ->assertDontSee('SMK Negeri 1 Contoh')
                ->assertDontSee('CV Teknologi Contoh')
                ->assertDontSee('Placeholder');
        }
    }

    public function test_beranda_dan_halaman_tentang_menampilkan_profil_yang_dilengkapi(): void
    {
        $this->seed();

        $this->get('/')
            ->assertOk()
            ->assertSee('Olivia Margaret')
            ->assertDontSee('Olivia Putri')
            ->assertSee('XII PPLG 1')
            ->assertSee('Pengembangan Perangkat Lunak dan Gim')
            ->assertSee('image/profil.jpeg')
            ->assertSee('Keahlian yang saya kembangkan')
            ->assertSee('Lihat Proyek')
            ->assertSee('CV Digital')
            ->assertSee('Hubungi Saya')
            ->assertDontSee('0+');

        $this->get('/about')
            ->assertOk()
            ->assertSee('Saya Olivia Margaret, siswi kelas XII PPLG')
            ->assertDontSee('Olivia Putri')
            ->assertSee('website company profile untuk SDIT Hunafa')
            ->assertSee('Mengembangkan diri sebagai web developer')
            ->assertDontSee('Placeholder');
    }

    public function test_public_profile_name_is_consistent_across_profile_and_testimonial_pages(): void
    {
        $this->seed();

        $this->assertDatabaseHas('settings', [
            'key' => 'site_name',
            'value' => 'Portofolio Olivia Margaret',
        ]);

        foreach (['/', '/about', '/cv', '/cv/print', '/testimonials'] as $path) {
            $this->get($path)
                ->assertOk()
                ->assertSee('Olivia Margaret')
                ->assertDontSee('Olivia Putri');
        }
    }

    public function test_keahlian_menampilkan_persentase_yang_sudah_dikonfirmasi(): void
    {
        $this->seed();

        $this->get('/skills')
            ->assertOk()
            ->assertSee('HTML')
            ->assertSee('80%')
            ->assertSee('CSS')
            ->assertSee('75%')
            ->assertSee('Laravel')
            ->assertSee('60%')
            ->assertSee('Komunikasi')
            ->assertSee('Persentase merupakan penilaian diri')
            ->assertDontSee('JavaScript')
            ->assertDontSee('PHP');
    }

    public function test_proyek_sdit_hunafa_menampilkan_deskripsi_dan_galeri(): void
    {
        $this->seed();

        $this->get('/projects')
            ->assertOk()
            ->assertSee('Website Company Profile SDIT Hunafa')
            ->assertSee('projects/sdit-hunafa-history.png')
            ->assertDontSee('Sistem Peminjaman Buku');

        $this->get('/projects/website-company-profile')
            ->assertOk()
            ->assertSee('Website Company Profile SDIT Hunafa')
            ->assertSee('bersama tim Belaset saat PLK kelas XI')
            ->assertSee('projects/sdit-hunafa-history.png')
            ->assertSee('Rancangan alur dan mockup website')
            ->assertSee('Halaman Fasilitas & Sarana')
            ->assertSee('Gambar Galeri')
            ->assertSee('2 gambar tambahan');
    }

    public function test_proyek_desain_media_pembelajaran_menampilkan_tujuan_dan_dokumentasi(): void
    {
        $this->seed();

        $this->get('/projects/desain-media-pembelajaran')
            ->assertOk()
            ->assertSee('Tantangan yang ingin dijawab')
            ->assertSee('Membuat rancangan visual media pembelajaran')
            ->assertSee('Figma')
            ->assertSee('Perancang desain')
            ->assertSee('bukan aplikasi yang sudah dikembangkan')
            ->assertDontSee('Gambar Galeri');
    }

    public function test_pengalaman_sdit_hunafa_ditampilkan_sebagai_plk_kelas_xi(): void
    {
        $this->seed();

        $this->get('/experiences')
            ->assertOk()
            ->assertSee('Praktik Lapangan Kerja (PLK)')
            ->assertSee('SDIT Hunafa')
            ->assertSee('Anggota Tim Belaset (PLK Kelas XI)');
    }

    public function test_kontak_dan_tombol_email_menampilkan_data_terbaru(): void
    {
        $this->seed();

        $this->get('/contact')
            ->assertOk()
            ->assertSee('olivimargaret3110@gmail.com')
            ->assertSee('@olvymrgt')
            ->assertSee('https://www.instagram.com/olvymrgt/')
            ->assertDontSee('olivia.putri@example.com');

        $this->get('/')
            ->assertOk()
            ->assertSee('Hubungi Saya')
            ->assertSee('mailto:olivimargaret3110@gmail.com');
    }

    public function test_halaman_detail_proyek_menampilkan_judul(): void
    {
        $project = Project::factory()->create(['title' => 'Proyek Alpha']);

        $this->get(route('projects.show', $project))
            ->assertOk()
            ->assertSee('Proyek Alpha');
    }

    public function test_proyek_tanpa_thumbnail_menampilkan_pratinjau_netral(): void
    {
        $project = Project::factory()->create([
            'title' => 'Proyek Tanpa Gambar',
            'thumbnail' => 'seed/placeholder.svg',
        ]);

        $this->get('/projects')
            ->assertOk()
            ->assertSee('Pratinjau gambar belum tersedia')
            ->assertDontSee('storage/seed/placeholder.svg');

        $this->get(route('projects.show', $project))
            ->assertOk()
            ->assertSee('Pratinjau gambar belum tersedia')
            ->assertDontSee('storage/seed/placeholder.svg');
    }

    public function test_halaman_proyek_dan_blog_tidak_menampilkan_teks_placeholder_seed(): void
    {
        $this->seed();

        $this->get('/projects')
            ->assertOk()
            ->assertDontSee('(Placeholder)');

        $this->get('/blog')
            ->assertOk()
            ->assertDontSee('(Placeholder)');

        $this->get('/testimonials')
            ->assertOk()
            ->assertDontSee('(Contoh)');
    }

    public function test_pencarian_dan_filter_proyek_bekerja(): void
    {
        Project::factory()->create(['title' => 'Proyek Alpha', 'category' => 'Web App']);
        Project::factory()->create(['title' => 'Proyek Beta', 'category' => 'Desktop App']);

        $this->get('/projects?q=Alpha')
            ->assertOk()
            ->assertSee('Proyek Alpha')
            ->assertDontSee('Proyek Beta');

        $this->get('/projects?category=Desktop+App')
            ->assertOk()
            ->assertSee('Proyek Beta')
            ->assertDontSee('Proyek Alpha');
    }

    public function test_artikel_yang_sudah_terbit_dapat_diakses(): void
    {
        $post = BlogPost::factory()->create([
            'title' => 'Artikel Terbit',
            'published_at' => now()->subDay(),
        ]);

        $this->get(route('blog.show', $post))
            ->assertOk()
            ->assertSee('Artikel Terbit');
    }

    public function test_artikel_yang_belum_terbit_menghasilkan_404(): void
    {
        $draft = BlogPost::factory()->create(['published_at' => null]);
        $scheduled = BlogPost::factory()->create(['published_at' => now()->addDay()]);

        $this->get(route('blog.show', $draft))->assertNotFound();
        $this->get(route('blog.show', $scheduled))->assertNotFound();
    }

    public function test_blog_memuat_lima_artikel_pengalaman_dengan_detail_dan_gambar(): void
    {
        $this->seed();

        $posts = BlogPost::query()->published()->get();
        $this->assertCount(5, $posts);

        $listing = $this->get(route('blog.index'))->assertOk();

        foreach ($posts as $post) {
            $this->assertNotSame('', $post->title);
            $this->assertNotSame('', $post->category);
            $this->assertNotSame('', $post->image);
            $this->assertNotSame('', $post->excerpt);
            $this->assertNotNull($post->published_at);

            $listing
                ->assertSee($post->title)
                ->assertSee($post->category)
                ->assertSee(substr($post->excerpt, 0, 60))
                ->assertSee(media_url($post->image))
                ->assertSee('Baca Artikel');

            $this->get(route('blog.show', $post))
                ->assertOk()
                ->assertSee($post->title)
                ->assertSee(media_url($post->image))
                ->assertSee('Semua artikel');
        }

        $this->assertDatabaseMissing('blog_posts', [
            'slug' => 'mengatasi-error-migration-laravel',
        ]);
    }

    public function test_blog_search_and_category_filter_return_matching_articles(): void
    {
        $this->seed();

        $this->get(route('blog.index', ['q' => 'Belaset']))
            ->assertOk()
            ->assertSee('Membuat Website Company Profile SDIT Hunafa Bersama Tim Belaset')
            ->assertDontSee('Pengalaman Mengembangkan Website Sistem Informasi Logistik Rumah Sakit Islam');

        $this->get(route('blog.index', ['category' => 'Pengalaman PLK']))
            ->assertOk()
            ->assertSee('Membuat Website Company Profile SDIT Hunafa Bersama Tim Belaset')
            ->assertSee('Pengalaman Mengembangkan Website Sistem Informasi Logistik Rumah Sakit Islam')
            ->assertDontSee('Perjalanan Belajar di Jurusan PPLG');
    }
}
