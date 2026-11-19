<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class TestimonialController extends Controller
{
    /**
     * Halaman testimoni dari guru, teman, pengguna, dan tempat PLK.
     */
    public function index(): View
    {
        return view('pages.testimonials', [
            'testimonials' => Testimonial::query()->with('project')->ordered()->get(),
            'categories' => Testimonial::CATEGORIES,
        ]);
    }
}
