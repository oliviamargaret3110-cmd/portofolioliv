<?php

namespace Database\Seeders;

use App\Models\BlogPost;
use App\Models\Profile;
use App\Models\Setting;
use Illuminate\Database\Seeder;

class PortfolioContentSeeder extends Seeder
{
    public function run(): void
    {
        $profile = Profile::query()->firstOrFail();
        $profile->update([
            'full_name' => 'Olivia Margaret',
            'bio' => str_replace('Olivia Putri', 'Olivia Margaret', (string) $profile->bio),
        ]);

        Setting::put('site_name', 'Portofolio Olivia Margaret');

        $siteDescription = str_replace(
            ['Portofolio Olivia,', 'Olivia Putri'],
            ['Portofolio Olivia Margaret,', 'Olivia Margaret'],
            (string) Setting::query()->where('key', 'site_description')->value('value')
        );
        Setting::put('site_description', $siteDescription);

        $posts = [
            [
                'title' => 'Pengalaman Membuat Desain Media Pembelajaran',
                'slug' => 'desain-media-pembelajaran-agar-siswa-lebih-tertarik',
                'category' => 'Pengalaman Belajar',
                'image' => 'projects/desain-media-pembelajaran.png',
                'excerpt' => 'Cerita tentang rancangan media pembelajaran yang saya buat saat kelas X agar siswa lebih tertarik belajar.',
                'content' => implode(PHP_EOL.PHP_EOL, [
                    'Saat kelas X, saya membuat rancangan visual media pembelajaran. Tujuan utamanya adalah membuat tampilan yang menarik agar siswa lebih tertarik menggunakan media tersebut.',
                    'Saya menyusun desainnya menggunakan Figma. Gambar pada artikel ini adalah dokumentasi rancangan yang saya buat. Hasilnya berupa desain visual, bukan aplikasi yang sudah dikembangkan.',
                    'Dari proyek ini saya belajar bahwa tampilan perlu dirancang dengan mempertimbangkan orang yang akan menggunakannya. Proyek ini menjadi salah satu pengalaman awal saya dalam membuat karya di bidang PPLG.',
                ]),
                'published_at' => '2026-11-14 05:54:22',
            ],
            [
                'title' => 'Pengalaman Mengembangkan Website Sistem Informasi Logistik Rumah Sakit Islam',
                'slug' => 'pengembangan-website-logistik-rumah-sakit-islam',
                'category' => 'Pengalaman PLK',
                'image' => 'image/superadmin.jpg',
                'excerpt' => 'Pengalaman PLK di Rumah Sakit Islam saat terlibat dalam pengembangan website logistik menggunakan Laravel, PHP, dan MySQL.',
                'content' => implode(PHP_EOL.PHP_EOL, [
                    'Pada Praktik Lapangan Kerja di Rumah Sakit Islam, saya terlibat dalam pengembangan website logistik. Proyek ini ditujukan untuk membantu pengelolaan kebutuhan logistik secara digital.',
                    'Dalam proyek tersebut saya mengenal penggunaan Laravel dan PHP untuk pengembangan aplikasi web serta MySQL untuk penyimpanan data. Saya juga belajar bahwa fitur perlu disesuaikan dengan kebutuhan pengguna dan tujuan sistem.',
                    'Gambar artikel ini menggunakan dokumentasi tampilan sistem logistik yang telah dipakai sebagai gambar proyek di portofolio. Pengalaman PLK ini membantu saya memahami penerapan materi PPLG pada sebuah proyek nyata.',
                ]),
            ],
            [
                'title' => 'Membuat Website Company Profile SDIT Hunafa Bersama Tim Belaset',
                'slug' => 'website-company-profile-sdit-hunafa',
                'category' => 'Pengalaman PLK',
                'image' => 'projects/sdit-hunafa-history.png',
                'excerpt' => 'Cerita bekerja bersama tim Belaset saat PLK kelas XI membuat website company profile untuk SDIT Hunafa.',
                'content' => implode(PHP_EOL.PHP_EOL, [
                    'Saat PLK kelas XI, saya bersama tim Belaset mengerjakan website company profile untuk SDIT Hunafa. Website tersebut dibuat sebagai media informasi tentang sekolah.',
                    'Dokumentasi proyek yang tersedia mencakup rancangan alur dan mockup, halaman sejarah, serta halaman Fasilitas & Sarana. Gambar pada artikel ini memperlihatkan dokumentasi halaman sejarah yang telah digunakan pada halaman proyek.',
                    'Melalui kerja bersama tim, saya belajar memahami kebutuhan proyek dan menyusun informasi sekolah ke dalam sebuah website. Proyek ini merupakan pengalaman kolaborasi saya selama PLK kelas XI.',
                ]),
            ],
            [
                'title' => 'Belajar Mengembangkan Website Menggunakan Laravel',
                'slug' => 'belajar-laravel-melalui-pengembangan-website',
                'category' => 'Teknologi',
                'image' => 'image/superadmin.jpg',
                'excerpt' => 'Catatan belajar Laravel melalui website logistik Rumah Sakit Islam dan pengembangan portofolio.',
                'content' => implode(PHP_EOL.PHP_EOL, [
                    'Saya belajar Laravel melalui pengalaman mengembangkan website, termasuk website logistik saat PLK di Rumah Sakit Islam. Proyek tersebut menggunakan Laravel, PHP, dan MySQL.',
                    'Dalam proses belajar, saya memahami bahwa routing menghubungkan alamat halaman dengan fitur yang dituju, sedangkan Blade membantu menyusun tampilan halaman. Data yang disimpan di database kemudian dapat digunakan untuk menampilkan konten website.',
                    'Saya terus mempelajari hubungan antara bagian-bagian tersebut sambil mengembangkan fitur berdasarkan kebutuhan proyek. Pengalaman ini menjadi bagian dari proses belajar saya sebagai siswa PPLG.',
                ]),
            ],
            [
                'title' => 'Perjalanan Belajar di Jurusan PPLG',
                'slug' => 'perjalanan-belajar-di-jurusan-pplg',
                'category' => 'Perjalanan Belajar',
                'image' => 'projects/desain-media-pembelajaran.png',
                'excerpt' => 'Perjalanan belajar pengembangan perangkat lunak melalui desain media pembelajaran dan proyek website.',
                'content' => implode(PHP_EOL.PHP_EOL, [
                    'Sebagai siswi jurusan Pengembangan Perangkat Lunak dan Gim (PPLG), saya belajar membuat karya digital secara bertahap. Pengalaman saya mencakup membuat desain media pembelajaran saat kelas X, lalu bekerja bersama tim Belaset pada website company profile SDIT Hunafa saat PLK kelas XI.',
                    'Saya juga terlibat dalam pengembangan website logistik Rumah Sakit Islam saat PLK. Dari proyek-proyek tersebut, saya mendapat pengalaman belajar yang berbeda: merancang tampilan, bekerja bersama tim, dan mengenal pengembangan website menggunakan Laravel, PHP, serta MySQL.',
                    'Saat ini saya terus mengembangkan keterampilan HTML, CSS, Laravel, dan komunikasi. Perjalanan tersebut masih berlanjut seiring proses belajar saya di jurusan PPLG.',
                ]),
            ],
        ];

        $legacySlugs = [
            'belajar-laravel-melalui-pengembangan-website' => 'belajar-laravel-dari-nol',
            'website-company-profile-sdit-hunafa' => 'mengatasi-error-migration-laravel',
            'pengembangan-website-logistik-rumah-sakit-islam' => 'pengalaman-praktik-lapangan-kerja',
        ];

        foreach ($posts as $postData) {
            $post = BlogPost::query()->firstOrNew(['slug' => $postData['slug']]);

            if (! $post->exists && isset($legacySlugs[$postData['slug']])) {
                $post = BlogPost::query()->firstOrNew(['slug' => $legacySlugs[$postData['slug']]]);
            }

            $publishedAt = $postData['published_at'] ?? $post->published_at ?? now();
            unset($postData['published_at']);

            $post->fill($postData);
            $post->published_at = $publishedAt;
            $post->save();
        }
    }
}
