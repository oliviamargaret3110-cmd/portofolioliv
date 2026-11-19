@extends('layouts.app')

@section('title', $project->title)
@section('meta_description', $project->short_description)

@section('content')
    <div class="border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900/40">
        <div class="container-page py-8">
            <nav class="flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Beranda</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <a href="{{ route('projects.index') }}" class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Proyek</a>
                <i class="fa-solid fa-chevron-right text-[9px]"></i>
                <span class="truncate text-slate-900 dark:text-white">{{ $project->title }}</span>
            </nav>

            <div class="mt-6 flex flex-wrap items-center gap-2">
                <span class="badge">{{ $project->category }}</span>
                @if ($project->is_featured)
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800 dark:bg-amber-500/10 dark:text-amber-300">
                        <i class="fa-solid fa-star"></i>
                        Proyek Unggulan
                    </span>
                @endif
            </div>

            <h1 class="mt-3 max-w-4xl text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl dark:text-white">
                {{ $project->title }}
            </h1>

            <p class="mt-4 max-w-3xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                {{ $project->short_description }}
            </p>

            <div class="mt-6 flex flex-wrap gap-3">
                @if ($project->demo_url)
                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="btn-primary">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        Lihat Demo
                    </a>
                @endif

                @if ($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="btn-outline">
                        <i class="fa-brands fa-github"></i>
                        Repositori GitHub
                    </a>
                @endif
            </div>
        </div>
    </div>

    <section class="container-page mt-10">
        <div class="grid gap-10 lg:grid-cols-[1.6fr_0.9fr]">
            <div>
                @if (filled($project->thumbnail) && ! str_starts_with($project->thumbnail, 'seed/'))
                    <button
                        type="button"
                        data-lightbox="{{ media_url($project->thumbnail) }}"
                        data-lightbox-alt="Thumbnail {{ $project->title }}"
                        class="group block w-full overflow-hidden rounded-2xl border border-slate-200 bg-slate-100 dark:border-slate-800 dark:bg-slate-800"
                        title="Perbesar gambar"
                    >
                        <img
                            src="{{ media_url($project->thumbnail) }}"
                            alt="Thumbnail proyek {{ $project->title }}"
                            class="aspect-video w-full object-cover transition duration-500 group-hover:scale-[1.02]"
                        >
                    </button>
                @else
                    <x-project-placeholder
                        :title="$project->title"
                        :category="$project->category ?? 'Proyek'"
                        class="aspect-video w-full overflow-hidden rounded-2xl border border-slate-200 dark:border-slate-800"
                    />
                @endif

                @if ($project->description)
                    <div class="mt-10">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Deskripsi Proyek</h2>
                        <div class="mt-3 space-y-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            {!! nl2br(e($project->description)) !!}
                        </div>
                    </div>
                @endif

                @if ($project->problem || $project->goal)
                    <div class="mt-8 grid gap-4 sm:grid-cols-2">
                        @if ($project->problem)
                            <div class="card p-5" data-aos="fade-up">
                                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-rose-600 dark:text-rose-400">
                                    <i class="fa-solid fa-circle-exclamation"></i>
                                    Masalah
                                </p>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $project->problem }}</p>
                            </div>
                        @endif

                        @if ($project->goal)
                            <div class="card p-5" data-aos="fade-up" data-aos-delay="60">
                                <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-emerald-600 dark:text-emerald-400">
                                    <i class="fa-solid fa-bullseye"></i>
                                    Tujuan
                                </p>
                                <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $project->goal }}</p>
                            </div>
                        @endif
                    </div>
                @endif

                @if ($project->features)
                    <div class="mt-8">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Fitur Utama</h2>
                        <div class="mt-4 space-y-2">
                            @foreach (preg_split('/\r\n|\r|\n/', $project->features) as $feature)
                                @if (trim($feature) !== '')
                                    <div class="flex items-start gap-3 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-600 dark:border-slate-800 dark:bg-slate-900 dark:text-slate-300">
                                        <i class="fa-solid fa-circle-check mt-0.5 text-emerald-500"></i>
                                        <span>{{ trim($feature) }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($project->documentation)
                    <div class="mt-8">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Dokumentasi</h2>
                        <div class="mt-3 space-y-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                            {!! nl2br(e($project->documentation)) !!}
                        </div>
                    </div>
                @endif

                @if ($project->images->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Galeri Proyek</h2>
                        <div class="mt-4 grid gap-4 sm:grid-cols-2">
                            @foreach ($project->images as $image)
                                <figure class="overflow-hidden rounded-2xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
                                    <button
                                        type="button"
                                        data-lightbox="{{ media_url($image->image) }}"
                                        data-lightbox-alt="{{ $image->caption ?: 'Dokumentasi '.$project->title }}"
                                        class="block w-full overflow-hidden bg-slate-100 dark:bg-slate-800"
                                        title="Perbesar gambar"
                                    >
                                        <img src="{{ media_url($image->image) }}" alt="{{ $image->caption ?: 'Dokumentasi '.$project->title }}" loading="lazy" class="aspect-video w-full object-cover transition duration-500 hover:scale-105">
                                    </button>

                                    @if ($image->caption)
                                        <figcaption class="px-4 py-3 text-xs text-slate-500 dark:text-slate-400">{{ $image->caption }}</figcaption>
                                    @endif
                                </figure>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($project->testimonials->isNotEmpty())
                    <div class="mt-10">
                        <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Testimoni Proyek</h2>
                        <div class="mt-4 space-y-4">
                            @foreach ($project->testimonials as $testimonial)
                                <figure class="card p-5">
                                    <blockquote class="text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                                        &ldquo;{{ $testimonial->content }}&rdquo;
                                    </blockquote>
                                    <figcaption class="mt-4 flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                                            {{ initials($testimonial->name) }}
                                        </span>
                                        <div>
                                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $testimonial->name }}</p>
                                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $testimonial->position }}</p>
                                        </div>
                                    </figcaption>
                                </figure>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="lg:sticky lg:top-24 lg:h-fit">
                <div class="card p-6">
                    <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400">Informasi Proyek</h2>

                    <dl class="mt-4 space-y-4 text-sm">
                        <div>
                            <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Kategori</dt>
                            <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">{{ $project->category }}</dd>
                        </div>

                        @if ($project->role)
                            <div>
                                <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Peran</dt>
                                <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">{{ $project->role }}</dd>
                            </div>
                        @endif

                        @if ($project->technologies)
                            <div>
                                <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Teknologi</dt>
                                <dd class="mt-2 flex flex-wrap gap-1.5">
                                    @foreach (array_filter(array_map('trim', explode(',', $project->technologies))) as $technology)
                                        <span class="rounded-md bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $technology }}</span>
                                    @endforeach
                                </dd>
                            </div>
                        @endif

                        @if ($project->images->isNotEmpty())
                            <div>
                                <dt class="text-xs font-medium text-slate-500 dark:text-slate-400">Gambar Galeri</dt>
                                <dd class="mt-0.5 font-semibold text-slate-900 dark:text-white">{{ $project->images->count() }} gambar tambahan</dd>
                            </div>
                        @endif
                    </dl>

                    <div class="mt-6 border-t border-slate-100 pt-5 dark:border-slate-800">
                        <a href="{{ route('contact.index') }}" class="btn-primary w-full">
                            <i class="fa-solid fa-paper-plane"></i>
                            Diskusikan Proyek
                        </a>
                    </div>
                </div>

                @if ($relatedProjects->isNotEmpty())
                    <div class="card mt-6 p-6">
                        <h2 class="text-sm font-bold uppercase tracking-widest text-slate-400">Proyek Serupa</h2>

                        <div class="mt-4 space-y-3">
                            @foreach ($relatedProjects as $related)
                                <a href="{{ route('projects.show', $related) }}" class="group flex items-center gap-3">
                                    <img src="{{ media_url($related->thumbnail) }}" alt="Thumbnail {{ $related->title }}" loading="lazy" class="h-14 w-20 shrink-0 rounded-lg object-cover">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-slate-900 transition group-hover:text-indigo-600 dark:text-white dark:group-hover:text-indigo-400">{{ $related->title }}</p>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $related->category }}</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </aside>
        </div>

        <div class="mt-12">
            <a href="{{ route('projects.index') }}" class="btn-outline">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke daftar proyek
            </a>
        </div>
    </section>
@endsection
