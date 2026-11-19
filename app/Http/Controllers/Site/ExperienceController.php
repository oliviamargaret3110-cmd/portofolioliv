<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Experience;
use Illuminate\Contracts\View\View;

class ExperienceController extends Controller
{
    /**
     * Halaman pengalaman: PLK, organisasi, dan lomba.
     */
    public function index(): View
    {
        return view('pages.experiences', [
            'experiences' => Experience::query()->ordered()->get(),
            'types' => Experience::TYPES,
        ]);
    }
}
