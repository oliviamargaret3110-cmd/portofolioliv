@extends('layouts.app')

@section('title', 'Proyek')
@section('meta_description', 'Kumpulan proyek yang saya kerjakan selama belajar di jurusan PPLG.')

@section('content')
    <x-page-header eyebrow="Portofolio" title="Proyek yang saya kerjakan" description="Jelajahi proyek dan desain yang saya kerjakan selama belajar di jurusan PPLG. Gunakan pencarian atau filter kategori untuk menemukan proyek tertentu." />

    <section class="container-page mt-10">
        <form method="GET" action="{{ route('projects.index') }}" class="card p-4 sm:p-5">
            <div class="grid gap-3 sm:grid-cols-[1fr_auto_auto]">
                <div class="relative">
                    <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                    <input
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Cari judul atau teknologi..."
                        class="input pl-10"
                        aria-label="Cari proyek"
                    >
                </div>

                <select name="category" class="input sm:w-56" aria-label="Filter kategori">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category }}" @selected($activeCategory === $category)>{{ $category }}</option>
                    @endforeach
                </select>

                <div class="flex gap-2">
                    <button type="submit" class="btn-primary flex-1 sm:flex-none">
                        <i class="fa-solid fa-filter"></i>
                        Filter
                    </button>

                    @if ($search !== '' || $activeCategory !== '')
                        <a href="{{ route('projects.index') }}" class="btn-outline" aria-label="Reset filter" title="Reset filter">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Menampilkan <span class="font-semibold text-slate-900 dark:text-white">{{ $projects->total() }}</span> proyek
                @if ($search !== '')
                    untuk pencarian &ldquo;{{ $search }}&rdquo;
                @endif
            </p>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('projects.index') }}" class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ $activeCategory === '' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-indigo-600 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-800' }}">Semua</a>
                @foreach ($categories as $category)
                    <a href="{{ route('projects.index', ['category' => $category, 'q' => $search ?: null]) }}" class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ $activeCategory === $category ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-indigo-600 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-800' }}">
                        {{ $category }}
                    </a>
                @endforeach
            </div>
        </div>

        @if ($projects->isEmpty())
            <div class="card mt-8 p-12 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <i class="fa-solid fa-folder-open text-xl"></i>
                </span>
                <h2 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Proyek tidak ditemukan</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                <a href="{{ route('projects.index') }}" class="btn-outline mt-5">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset filter
                </a>
            </div>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($projects as $project)
                    @include('partials.project-card', ['project' => $project])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $projects->links() }}
            </div>
        @endif
    </section>
@endsection
