<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use Illuminate\Contracts\View\View;

class CvController extends Controller
{
    /**
     * Tampilan CV digital (halaman web).
     */
    public function show(): View
    {
        return view('pages.cv', $this->cvData());
    }

    /**
     * Tampilan CV khusus cetak/PDF. Pengguna menekan tombol cetak
     * untuk menyimpan sebagai PDF melalui dialog browser.
     */
    public function print(): View
    {
        return view('pages.cv-print', $this->cvData());
    }

    /**
     * Data bersama untuk halaman CV web dan versi cetak.
     *
     * @return array<string, mixed>
     */
    private function cvData(): array
    {
        return [
            'profile' => Profile::query()->first(),
            'educations' => Education::query()->ordered()->get(),
            'experiences' => Experience::query()->ordered()->get(),
            'hardSkills' => Skill::query()->hard()->ordered()->get(),
            'softSkills' => Skill::query()->soft()->ordered()->get(),

            // CV hanya menampilkan data final. Baris contoh/placeholder dari
            // seeder disaring agar tidak ikut tercetak di PDF.
            'certificates' => Certificate::query()
                ->ordered()
                ->get()
                ->reject(fn (Certificate $certificate): bool => has_placeholder(
                    $certificate->title.' '.$certificate->organizer.' '.$certificate->description
                ))
                ->take(6)
                ->values(),
            'projects' => Project::query()
                ->ordered()
                ->get()
                ->reject(fn (Project $project): bool => has_placeholder(
                    $project->title.' '.$project->short_description.' '.$project->description
                ))
                ->take(4)
                ->values(),
        ];
    }
}
