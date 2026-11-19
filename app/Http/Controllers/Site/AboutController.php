<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Skill;
use Illuminate\Contracts\View\View;

class AboutController extends Controller
{
    /**
     * Halaman tentang saya: profil lengkap, riwayat pendidikan,
     * keahlian, dan pengalaman.
     */
    public function index(): View
    {
        return view('pages.about', [
            'profile' => Profile::query()->first(),
            'educations' => Education::query()->ordered()->get(),
            'skills' => Skill::query()->ordered()->get(),
            'experiences' => Experience::query()->ordered()->get(),
        ]);
    }
}
