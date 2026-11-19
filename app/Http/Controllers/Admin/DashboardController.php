<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Certificate;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Message;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Testimonial;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Ringkasan statistik konten dan aktivitas terbaru.
     */
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                ['label' => 'Proyek', 'value' => Project::query()->count(), 'icon' => 'fa-solid fa-layer-group', 'color' => 'indigo', 'route' => route('admin.projects.index')],
                ['label' => 'Sertifikat', 'value' => Certificate::query()->count(), 'icon' => 'fa-solid fa-certificate', 'color' => 'amber', 'route' => route('admin.certificates.index')],
                ['label' => 'Keahlian', 'value' => Skill::query()->count(), 'icon' => 'fa-solid fa-chart-simple', 'color' => 'sky', 'route' => route('admin.skills.index')],
                ['label' => 'Pengalaman', 'value' => Experience::query()->count(), 'icon' => 'fa-solid fa-briefcase', 'color' => 'emerald', 'route' => route('admin.experiences.index')],
                ['label' => 'Pendidikan', 'value' => Education::query()->count(), 'icon' => 'fa-solid fa-graduation-cap', 'color' => 'violet', 'route' => route('admin.educations.index')],
                ['label' => 'Testimoni', 'value' => Testimonial::query()->count(), 'icon' => 'fa-solid fa-comment-dots', 'color' => 'rose', 'route' => route('admin.testimonials.index')],
                ['label' => 'Artikel', 'value' => BlogPost::query()->count(), 'icon' => 'fa-solid fa-pen-nib', 'color' => 'cyan', 'route' => route('admin.posts.index')],
                ['label' => 'Pesan Belum Dibaca', 'value' => Message::query()->unread()->count(), 'icon' => 'fa-solid fa-inbox', 'color' => 'orange', 'route' => route('admin.messages.index')],
            ],
            'recentMessages' => Message::query()->latest()->take(5)->get(),
            'recentProjects' => Project::query()->ordered()->take(4)->get(),
        ]);
    }
}
