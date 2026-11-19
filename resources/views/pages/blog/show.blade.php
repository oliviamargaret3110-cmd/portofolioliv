@extends('layouts.app')

@section('title', $post->title)
@section('meta_description', $post->excerpt)

@section('content')
    <article class="container-page mt-8">
        <nav class="flex flex-wrap items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
            <a href="{{ route('home') }}" class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Beranda</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <a href="{{ route('blog.index') }}" class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Blog</a>
            <i class="fa-solid fa-chevron-right text-[9px]"></i>
            <span class="truncate text-slate-900 dark:text-white">{{ $post->title }}</span>
        </nav>

        <header class="mx-auto mt-8 max-w-3xl text-center">
            <div class="flex flex-wrap items-center justify-center gap-2">
                <span class="badge">{{ $post->category }}</span>
                <span class="text-xs text-slate-400">&bull;</span>
                <span class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ format_date_id($post->published_at) }}</span>
            </div>

            <h1 class="mt-4 text-3xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-4xl lg:text-5xl dark:text-white">
                {{ $post->title }}
            </h1>

            @if ($post->excerpt)
                <p class="mx-auto mt-4 max-w-2xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    {{ $post->excerpt }}
                </p>
            @endif
        </header>

        <div class="mx-auto mt-8 max-w-4xl">
            <img
                src="{{ media_url($post->image) }}"
                alt="Gambar artikel {{ $post->title }}"
                class="aspect-[16/9] w-full rounded-2xl border border-slate-200 object-cover shadow-sm dark:border-slate-800"
            >
        </div>

        <div class="mx-auto mt-10 max-w-3xl">
            <div class="space-y-4 text-base leading-relaxed text-slate-700 dark:text-slate-300">
                {!! nl2br(e($post->content)) !!}
            </div>

            <div class="mt-10 flex flex-wrap items-center justify-between gap-4 border-t border-slate-200 pt-6 dark:border-slate-800">
                <a href="{{ route('blog.index') }}" class="btn-outline">
                    <i class="fa-solid fa-arrow-left"></i>
                    Semua artikel
                </a>

                <div class="text-xs text-slate-500 dark:text-slate-400">
                    Dipublikasikan {{ format_date_id($post->published_at) }}
                </div>
            </div>
        </div>
    </article>

    @if ($relatedPosts->isNotEmpty())
        <section class="mt-16 bg-white py-14 dark:bg-slate-900/40">
            <div class="container-page">
                <x-section-heading eyebrow="Baca juga" title="Artikel lainnya" />

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($relatedPosts as $related)
                        @include('partials.post-card', ['post' => $related])
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
