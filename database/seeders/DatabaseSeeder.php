<?php

namespace Database\Seeders;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\Setting;
use App\Models\Skill;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Mengisi data awal.
     *
     * Pendidikan, pengalaman, dan kontak sudah memakai data asli pemilik
     * portofolio. Bagian yang belum memiliki data asli tetap memakai
     * placeholder dan bisa dilengkapi melalui Dashboard Admin.
     */
    public function run(): void
    {
        // 1. Akun admin (password: "password" - wajib diganti setelah login)
        $admin = User::firstOrCreate(
            ['email' => 'admin@portfolio.test'],
            [
                'name' => 'Admin Portofolio',
                'password' => Hash::make('password'),
            ]
        );
        $admin->forceFill(['is_admin' => true, 'is_superadmin' => true])->save();

        // 2. Profil pemilik portofolio (kontak sudah data asli)
        Profile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'full_name' => 'Olivia Margaret',
                'headline' => 'Siswa PPLG | Web Developer Pemula',
                'photo' => 'seed/avatar.svg',
                'class_name' => 'XII PPLG 1',
                'major' => 'Pengembangan Perangkat Lunak dan Gim',
                'bio' => 'Saya Olivia Margaret, siswi kelas XII PPLG di SMK Negeri 2 Banjarmasin. Saya tertarik pada pengembangan website dan desain media pembelajaran. Saat kelas X, saya membuat desain media pembelajaran agar siswa lebih tertarik menggunakannya. Saat PLK kelas XI, saya bersama tim Belaset mengerjakan website company profile untuk SDIT Hunafa. Dari pengalaman tersebut, saya belajar merancang tampilan dan bekerja sama dalam proyek.',
                'career_goal' => 'Mengembangkan diri sebagai web developer dan membuat aplikasi web yang bermanfaat bagi penggunanya.',
                'email' => 'olivimargaret3110@gmail.com',
                'phone' => null,
                'location' => 'Indonesia',
                'github_url' => null,
                'instagram_url' => 'https://www.instagram.com/olvymrgt/',
                'linkedin_url' => null,
            ]
        );

        // 3. Riwayat pendidikan (data asli)
        $educations = [
            ['level' => 'SMK', 'school_name' => 'SMK Negeri 2 Banjarmasin', 'major' => 'Pengembangan Perangkat Lunak dan Gim (PPLG)', 'start_year' => '2024', 'end_year' => '2027', 'description' => null, 'sort_order' => 1],
            ['level' => 'SMP', 'school_name' => 'SMP Negeri 13 Banjarmasin', 'major' => null, 'start_year' => '2021', 'end_year' => '2024', 'description' => null, 'sort_order' => 2],
            ['level' => 'SD', 'school_name' => 'SD Negeri 2 Alalak', 'major' => null, 'start_year' => '2015', 'end_year' => '2021', 'description' => null, 'sort_order' => 3],
        ];

        foreach ($educations as $education) {
            Education::updateOrCreate(
                ['school_name' => $education['school_name']],
                $education
            );
        }

        // 4. Keahlian dengan persentase penilaian diri yang sudah dikonfirmasi
        $skills = [
            ['name' => 'HTML', 'category' => 'hard', 'percentage' => 80, 'sort_order' => 1],
            ['name' => 'CSS', 'category' => 'hard', 'percentage' => 75, 'sort_order' => 2],
            ['name' => 'Laravel', 'category' => 'hard', 'percentage' => 60, 'sort_order' => 3],
            ['name' => 'Komunikasi', 'category' => 'soft', 'percentage' => 80, 'sort_order' => 1],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                $skill
            );
        }

        // 5. Proyek (placeholder, tanpa link palsu)
        $projects = [
            [
                'title' => 'Sistem Informasi Logistik PKL RS',
                'slug' => 'sistem-informasi-logistik-pkl-rs',
                'category' => 'Web App',
                'thumbnail' => 'image/superadmin.jpg',
                'short_description' => 'Website logistik yang dikembangkan saat PLK untuk membantu pengelolaan kebutuhan logistik secara digital.',
                'description' => 'Saya terlibat dalam pengembangan website logistik selama Praktik Lapangan Kerja di Rumah Sakit Islam. Website ini dikembangkan untuk membantu proses pengelolaan kebutuhan logistik secara digital. Pengalaman ini memberi saya kesempatan belajar mengembangkan fitur berdasarkan kebutuhan pengguna menggunakan Laravel, PHP, dan MySQL.',
                'problem' => null,
                'goal' => 'Membantu proses pengelolaan kebutuhan logistik secara digital.',
                'technologies' => 'Laravel, PHP, MySQL',
                'role' => 'Peserta PLK - Pengembangan Website',
                'features' => null,
                'documentation' => null,
                'demo_url' => null,
                'github_url' => null,
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Website Company Profile SDIT Hunafa',
                'slug' => 'website-company-profile',
                'category' => 'Website',
                'thumbnail' => 'projects/sdit-hunafa-history.png',
                'short_description' => 'Website company profile untuk SDIT Hunafa, dikerjakan bersama tim Belaset saat PLK kelas XI.',
                'description' => 'Proyek website company profile untuk SDIT Hunafa ini dikerjakan bersama tim Belaset saat PLK kelas XI. Website ini menyajikan informasi sekolah, termasuk sejarah, fasilitas, program, dan prestasi.',
                'problem' => null,
                'goal' => 'Menyediakan media informasi online untuk memperkenalkan SDIT Hunafa.',
                'technologies' => null,
                'role' => 'Anggota tim Belaset',
                'features' => null,
                'documentation' => 'Dokumentasi yang tersedia mencakup rancangan alur dan mockup website, halaman Fasilitas & Sarana, serta halaman sejarah SDIT Hunafa.',
                'demo_url' => null,
                'github_url' => null,
                'is_featured' => false,
                'sort_order' => 2,
            ],
        ];

        $legacyLogisticsProject = Project::query()
            ->where('slug', 'aplikasi-kasir-sederhana')
            ->first();

        if ($legacyLogisticsProject !== null && ! Project::query()->where('slug', 'sistem-informasi-logistik-pkl-rs')->exists()) {
            $legacyLogisticsProject->update(['slug' => 'sistem-informasi-logistik-pkl-rs']);
        }

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );
        }

        ProjectImage::query()
            ->where('caption', 'Tampilan utama aplikasi (placeholder)')
            ->delete();

        $sditHunafaProject = Project::query()
            ->where('slug', 'website-company-profile')
            ->firstOrFail();

        foreach ([
            [
                'image' => 'projects/sdit-hunafa-flow.png',
                'caption' => 'Rancangan alur dan mockup website',
                'sort_order' => 1,
            ],
            [
                'image' => 'projects/sdit-hunafa-facilities.png',
                'caption' => 'Halaman Fasilitas & Sarana',
                'sort_order' => 2,
            ],
        ] as $imageData) {
            $sditHunafaProject->images()->updateOrCreate(
                ['image' => $imageData['image']],
                $imageData
            );
        }

        Project::updateOrCreate(
            ['slug' => 'desain-media-pembelajaran'],
            [
                'title' => 'Desain Media Pembelajaran',
                'category' => 'Desain Media Pembelajaran',
                'thumbnail' => 'projects/desain-media-pembelajaran.png',
                'short_description' => 'Rancangan media pembelajaran yang saya buat saat kelas X agar siswa lebih tertarik menggunakannya.',
                'description' => 'Proyek ini berupa rancangan visual media pembelajaran yang saya buat saat kelas X. Tujuannya agar siswa lebih tertarik menggunakan media pembelajaran. Hasilnya berupa desain, bukan aplikasi yang sudah dikembangkan.',
                'problem' => 'Tantangan yang ingin dijawab adalah bagaimana merancang tampilan media pembelajaran agar siswa lebih tertarik menggunakannya.',
                'goal' => 'Membuat rancangan visual media pembelajaran yang menarik agar siswa lebih tertarik menggunakannya.',
                'technologies' => 'Figma',
                'role' => 'Perancang desain',
                'features' => null,
                'documentation' => 'Dokumentasi berupa screenshot rancangan di Figma. Proyek ini belum diimplementasikan menjadi aplikasi.',
                'demo_url' => null,
                'github_url' => null,
                'is_featured' => false,
                'sort_order' => 0,
            ]
        );

        // 6. Sertifikat & prestasi
        // Belum ada data sertifikat asli. Data contoh tidak diisi agar tidak
        // menampilkan prestasi yang tidak pernah diraih. Tambahkan melalui
        // Dashboard Admin jika sudah ada sertifikat sungguhan.

        // 7. Pengalaman PLK (data asli)
        $experiences = [
            [
                'title' => 'Pengembangan Website SDIT Hunafa',
                'organization' => 'SDIT Hunafa',
                'position' => 'Anggota Tim Belaset (PLK Kelas XI)',
                'type' => 'plk',
                'start_date' => null,
                'end_date' => null,
                'is_current' => false,
                'description' => 'Saat kelas XI, mengikuti PLK dan bersama tim Belaset mengerjakan website company profile untuk SDIT Hunafa sebagai klien. Tim bekerja sama memahami kebutuhan klien, merancang tampilan, dan mengembangkan website sebagai media informasi sekolah.',
                'sort_order' => 1,
            ],
            [
                'title' => 'Pengembangan Website Logistik Rumah Sakit Islam',
                'organization' => 'Rumah Sakit Islam',
                'position' => 'Praktik Lapangan Kerja (PLK)',
                'type' => 'plk',
                'start_date' => '2026-07-27',
                'end_date' => '2026-11-27',
                'is_current' => false,
                'description' => 'Melaksanakan Praktik Lapangan Kerja di Rumah Sakit Islam dengan terlibat dalam pengembangan website logistik. Website ini dikembangkan untuk membantu proses pengelolaan kebutuhan logistik secara digital. Selama kegiatan, memperoleh pengalaman dalam pengembangan aplikasi berbasis web menggunakan Laravel, PHP, dan MySQL, serta mempelajari proses pengembangan fitur berdasarkan kebutuhan pengguna.',
                'sort_order' => 2,
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::updateOrCreate(
                ['title' => $experience['title']],
                $experience + ['image' => null]
            );
        }

        Testimonial::query()
            ->whereIn('name', [
                'Guru Pembimbing (Contoh)',
                'Teman Sekelas (Contoh)',
                'Pengguna (Contoh)',
                'Tempat PLK (Contoh)',
            ])
            ->delete();

        // 8. Pengaturan website.
        Setting::put('site_name', 'Portofolio Olivia Margaret');
        Setting::put('site_tagline', 'Personal Portfolio Siswa PPLG');
        Setting::put('site_description', 'Portofolio Olivia Margaret, siswa PPLG yang menampilkan proyek, desain media pembelajaran, pengalaman, dan keahlian.');
        Setting::put('footer_text', 'Dibuat dengan Laravel, MySQL, dan Tailwind CSS.');

        $this->call(PortfolioContentSeeder::class);
    }
}
