@extends('layouts.app')

@section('title', 'Blog')
@section('meta_description', 'Artikel, catatan belajar, dan tutorial singkat.')

@section('content')
    <x-page-header eyebrow="Blog" title="Catatan & artikel" description="Tulisan singkat tentang proses belajar, teknologi yang saya pelajari, dan pengalaman mengerjakan proyek." />

    <section class="container-page mt-10">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('blog.index') }}" class="rounded-full px-3.5 py-2 text-xs font-semibold transition {{ $activeCategory === '' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-indigo-600 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-800' }}">
                    Semua
                </a>

                @foreach ($categories as $category)
                    <a href="{{ route('blog.index', ['category' => $category, 'q' => $search ?: null]) }}" class="rounded-full px-3.5 py-2 text-xs font-semibold transition {{ $activeCategory === $category ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-indigo-600 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-800' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('blog.index') }}" class="flex w-full gap-2 lg:w-auto">
                @if ($activeCategory !== '')
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif

                <div class="relative flex-1 lg:w-72">
                    <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari artikel..." class="input pl-10" aria-label="Cari artikel">
                </div>

                <button type="submit" class="btn-primary shrink-0" aria-label="Cari">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        @if ($posts->isEmpty())
            <div class="card mt-8 p-12 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <i class="fa-solid fa-pen-nib text-xl"></i>
                </span>
                <h2 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Artikel tidak ditemukan</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Coba kata kunci lain atau tampilkan semua artikel.</p>
                <a href="{{ route('blog.index') }}" class="btn-outline mt-5">
                    <i class="fa-solid fa-rotate-left"></i>
                    Tampilkan semua
                </a>
            </div>
        @else
            <div @class([
                'mx-auto mt-8 grid w-full gap-6',
                'max-w-2xl grid-cols-1' => $posts->count() === 1,
                'max-w-5xl grid-cols-1 sm:grid-cols-2' => $posts->count() === 2,
                'max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-3' => $posts->count() > 2,
            ])>
                @foreach ($posts as $post)
                    @include('partials.post-card', ['post' => $post])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $posts->links() }}
            </div>
        @endif
    </section>
@endsection
