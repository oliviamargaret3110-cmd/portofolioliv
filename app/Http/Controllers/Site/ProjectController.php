<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Daftar proyek dengan pencarian judul/teknologi dan filter kategori.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $category = (string) $request->query('category');

        $projects = Project::query()
            ->with('images')
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('short_description', 'like', "%{$search}%")
                        ->orWhere('technologies', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->ordered()
            ->paginate(9)
            ->withQueryString();

        return view('pages.projects.index', [
            'projects' => $projects,
            'categories' => Project::query()->select('category')->distinct()->orderBy('category')->pluck('category'),
            'search' => $search,
            'activeCategory' => $category,
        ]);
    }

    /**
     * Detail proyek beserta galeri, dokumentasi, dan testimoni terkait.
     */
    public function show(Project $project): View
    {
        $project->load(['images', 'testimonials']);

        $relatedProjects = Project::query()
            ->whereKeyNot($project->getKey())
            ->where('category', $project->category)
            ->ordered()
            ->take(3)
            ->get();

        return view('pages.projects.show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
        ]);
    }
}
