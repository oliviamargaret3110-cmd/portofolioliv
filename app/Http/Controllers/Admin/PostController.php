<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Support\ImageStorage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index(): View
    {
        return view('admin.posts.index', [
            'posts' => BlogPost::query()->latest('published_at')->latest()->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new BlogPost(['published_at' => now()]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['slug'] = $this->uniqueSlug($request->string('title')->toString());
        $validated['image'] = ImageStorage::store($request->file('image'), 'posts');

        BlogPost::query()->create($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function show(BlogPost $post): RedirectResponse
    {
        return redirect()->route('admin.posts.edit', $post);
    }

    public function edit(BlogPost $post): View
    {
        return view('admin.posts.form', ['post' => $post]);
    }

    public function update(Request $request, BlogPost $post): RedirectResponse
    {
        $validated = $this->validated($request);

        if ($request->filled('title') && $request->string('title')->toString() !== $post->title) {
            $validated['slug'] = $this->uniqueSlug($request->string('title')->toString(), $post->id);
        }

        $validated['image'] = ImageStorage::replace($request->file('image'), 'posts', $post->image);

        $post->update($validated);

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(BlogPost $post): RedirectResponse
    {
        ImageStorage::delete($post->image);
        $post->delete();

        return redirect()
            ->route('admin.posts.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'category' => ['required', 'string', 'max:50'],
            'image' => ['nullable', 'image', 'max:4096'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
        ], [
            'title.required' => 'Judul artikel wajib diisi.',
            'category.required' => 'Kategori wajib diisi.',
            'content.required' => 'Isi artikel wajib diisi.',
        ]);
    }

    /**
     * Buat slug unik dari judul artikel.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'artikel';
        $slug = $base;
        $counter = 2;

        while (BlogPost::query()->where('slug', $slug)->when($ignoreId, fn ($query) => $query->whereKeyNot($ignoreId))->exists()) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
