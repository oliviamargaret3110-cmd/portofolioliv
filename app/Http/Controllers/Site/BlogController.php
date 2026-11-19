<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Daftar artikel yang sudah dipublikasikan.
     */
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $category = (string) $request->query('category');

        $posts = BlogPost::query()
            ->published()
            ->when($search !== '', function ($query) use ($search) {
                $query->where(function ($inner) use ($search) {
                    $inner->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->when($category !== '', fn ($query) => $query->where('category', $category))
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        return view('pages.blog.index', [
            'posts' => $posts,
            'categories' => BlogPost::query()->published()->select('category')->distinct()->orderBy('category')->pluck('category'),
            'search' => $search,
            'activeCategory' => $category,
        ]);
    }

    /**
     * Detail artikel. Artikel yang belum/tidak dipublikasikan menghasilkan 404.
     */
    public function show(BlogPost $post): View
    {
        abort_unless($post->published_at !== null && $post->published_at->isPast(), 404);

        $relatedPosts = BlogPost::query()
            ->published()
            ->whereKeyNot($post->getKey())
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('pages.blog.show', [
            'post' => $post,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
