<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Support\ImageStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    public function index(): View
    {
        return view('admin.projects.index', [
            'projects' => Project::query()->withCount('images')->ordered()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.form', [
            'project' => new Project(['is_featured' => false, 'sort_order' => 0]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = $this->uniqueSlug($request->string('title')->toString());
        $validated['thumbnail'] = ImageStorage::store($request->file('thumbnail'), 'projects');

        $project = Project::query()->create($validated);

        return redirect()
            ->route('admin.projects.show', $project)
            ->with('success', 'Proyek berhasil ditambahkan. Silakan tambahkan gambar dokumentasi bila perlu.');
    }

    public function show(Project $project): View
    {
        $project->load('images');

        return view('admin.projects.show', ['project' => $project]);
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.form', ['project' => $project]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->filled('title') && $request->string('title')->toString() !== $project->title) {
            $validated['slug'] = $this->uniqueSlug($request->string('title')->toString(), $project->id);
        }

        $validated['thumbnail'] = ImageStorage::replace($request->file('thumbnail'), 'projects', $project->thumbnail);

        $project->update($validated);

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek berhasil diperbarui.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        ImageStorage::delete($project->thumbnail);

        foreach ($project->images as $image) {
            ImageStorage::delete($image->image);
        }

        $project->delete();

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Proyek beserta gambarnya berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'thumbnail' => ['nullable', 'image', 'max:4096'],
            'short_description' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'problem' => ['nullable', 'string', 'max:2000'],
            'goal' => ['nullable', 'string', 'max:2000'],
            'technologies' => ['nullable', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:100'],
            'features' => ['nullable', 'string'],
            'documentation' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'is_featured' => ['nullable', 'boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ], [
            'title.required' => 'Judul proyek wajib diisi.',
            'category.required' => 'Kategori wajib diisi.',
            'short_description.required' => 'Deskripsi singkat wajib diisi.',
        ]);

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        return $validated;
    }

    /**
     * Buat slug unik dari judul proyek.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'proyek';
        $slug = $base;
        $counter = 2;

        while (Project::query()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
