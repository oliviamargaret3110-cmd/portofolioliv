<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Skill;
use Illuminate\Contracts\View\View;

class SkillController extends Controller
{
    /**
     * Halaman keahlian, dipisah antara hard skill dan soft skill.
     */
    public function index(): View
    {
        return view('pages.skills', [
            'hardSkills' => Skill::query()->hard()->ordered()->get(),
            'softSkills' => Skill::query()->soft()->ordered()->get(),
        ]);
    }
}
