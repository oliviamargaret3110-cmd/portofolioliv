@extends('layouts.app')

@section('title', 'Testimoni')
@section('meta_description', 'Testimoni dari guru pembimbing, teman, pengguna, dan tempat PLK.')

@section('content')
    <x-page-header eyebrow="Testimoni" title="Apa kata mereka" description="Masukan dan kesan dari orang-orang yang pernah bekerja sama atau melihat langsung proses belajar saya." />

    <section class="container-page mt-12">
        @if ($testimonials->isEmpty())
            <div class="card p-12 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <i class="fa-solid fa-comment-dots text-xl"></i>
                </span>
                <h2 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Belum ada testimoni</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Testimoni akan tampil di sini setelah ditambahkan melalui Dashboard Admin.</p>
            </div>
        @else
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($testimonials as $testimonial)
                    <figure class="card relative flex flex-col p-6" data-aos="fade-up" data-aos-delay="{{ ($loop->index % 3) * 60 }}">
                        <i class="fa-solid fa-quote-left absolute right-5 top-5 text-2xl text-indigo-100 dark:text-indigo-500/20"></i>

                        <span class="badge w-fit">{{ $categories[$testimonial->category] ?? $testimonial->category }}</span>

                        <blockquote class="mt-4 flex-1 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                            &ldquo;{{ $testimonial->content }}&rdquo;
                        </blockquote>

                        @if ($testimonial->project)
                            <a href="{{ route('projects.show', $testimonial->project) }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">
                                <i class="fa-solid fa-layer-group text-[10px]"></i>
                                Proyek: {{ $testimonial->project->title }}
                            </a>
                        @endif

                        <figcaption class="mt-5 flex items-center gap-3 border-t border-slate-100 pt-4 dark:border-slate-800">
                            @if ($testimonial->photo)
                                <img src="{{ media_url($testimonial->photo) }}" alt="Foto {{ $testimonial->name }}" class="h-11 w-11 rounded-full object-cover">
                            @else
                                <span class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                                    {{ initials($testimonial->name) }}
                                </span>
                            @endif

                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $testimonial->name }}</p>
                                <p class="truncate text-[11px] text-slate-500 dark:text-slate-400">{{ $testimonial->position }}</p>
                            </div>
                        </figcaption>
                    </figure>
                @endforeach
            </div>
        @endif
    </section>

    <section class="container-page mt-16">
        <div class="rounded-3xl border border-dashed border-indigo-300 bg-indigo-50/50 p-8 text-center dark:border-indigo-800 dark:bg-indigo-500/5">
            <i class="fa-regular fa-comment-dots text-2xl text-indigo-500"></i>
            <h2 class="mt-3 text-xl font-extrabold text-slate-900 dark:text-white">Pernah bekerja sama dengan saya?</h2>
            <p class="mx-auto mt-2 max-w-xl text-sm text-slate-600 dark:text-slate-400">
                Kirimkan kesan dan pesan Anda melalui halaman kontak. Testimoni yang dipilih akan ditampilkan di halaman ini.
            </p>
            <a href="{{ route('contact.index') }}" class="btn-primary mt-5">
                <i class="fa-solid fa-paper-plane"></i>
                Kirim Pesan
            </a>
        </div>
    </section>
@endsection
