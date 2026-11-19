<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Halaman beranda: ringkasan profil, keahlian unggulan,
     * proyek pilihan, sertifikat, pengalaman, testimoni, dan artikel terbaru.
     */
    public function index(): View
    {
        return view('pages.home', [
            'profile' => Profile::query()->first(),
            'skills' => Skill::query()->ordered()->take(8)->get(),
            'projects' => Project::query()->with('images')->ordered()->take(3)->get(),
            'certificates' => Certificate::query()->ordered()->take(3)->get(),
            'experiences' => Experience::query()->ordered()->take(3)->get(),
            'testimonials' => Testimonial::query()->ordered()->take(3)->get(),
            'posts' => BlogPost::query()->published()->latest('published_at')->take(3)->get(),
            'counts' => [
                'projects' => Project::query()->count(),
                'certificates' => Certificate::query()->count(),
                'experiences' => Experience::query()->count(),
                'skills' => Skill::query()->count(),
            ],
        ]);
    }
}
