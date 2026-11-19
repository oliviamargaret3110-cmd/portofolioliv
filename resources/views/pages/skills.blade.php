@extends('layouts.app')

@section('title', 'Keahlian')
@section('meta_description', 'Hard skill dan soft skill yang saya pelajari, beserta penilaian diri atas tingkat penguasaannya.')

@section('content')
    <x-page-header eyebrow="Keahlian" title="Hard skill & soft skill" description="Kemampuan teknis dan non-teknis yang saya pelajari. Persentase merupakan penilaian diri atas tingkat penguasaan saat ini." />

    <section class="container-page mt-12 space-y-12">
        @php
            $groups = [
                ['key' => 'hard', 'title' => 'Hard Skill', 'description' => 'Kemampuan teknis di bidang pemrograman, desain, dan pengelolaan data.', 'icon' => 'fa-solid fa-laptop-code', 'items' => $hardSkills],
                ['key' => 'soft', 'title' => 'Soft Skill', 'description' => 'Kemampuan interpersonal yang mendukung kerja sama dan penyelesaian masalah.', 'icon' => 'fa-solid fa-people-group', 'items' => $softSkills],
            ];
        @endphp

        @foreach ($groups as $group)
            <div>
                <div class="flex items-center gap-3" data-aos="fade-up">
                    <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-indigo-600 text-white shadow-lg shadow-indigo-600/20">
                        <i class="{{ $group['icon'] }}"></i>
                    </span>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">{{ $group['title'] }}</h2>
                        <p class="text-sm text-slate-500 dark:text-slate-400">{{ $group['description'] }}</p>
                    </div>
                </div>

                @if ($group['items']->isEmpty())
                    <div class="card mt-6 p-8 text-center text-sm text-slate-500 dark:text-slate-400">
                        Belum ada data {{ strtolower($group['title']) }}.
                    </div>
                @else
                    <div class="mt-6 grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($group['items'] as $skill)
                            <div class="card p-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                                <div class="flex items-start justify-between gap-3">
                                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                        <i class="{{ $skill->icon ?: 'fa-solid fa-code' }}"></i>
                                    </span>
                                    <span class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-bold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                        {{ $skill->percentage }}%
                                    </span>
                                </div>

                                <h3 class="mt-4 text-base font-bold text-slate-900 dark:text-white">{{ $skill->name }}</h3>
                                <p class="text-xs capitalize text-slate-500 dark:text-slate-400">{{ $skill->category }} skill</p>

                                <div class="mt-4 h-2 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                    <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-sky-500" style="width: {{ max(0, min(100, $skill->percentage)) }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </section>

    <section class="container-page mt-16">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-slate-900 to-indigo-900 p-8 sm:p-12" data-aos="zoom-in">
            <div class="pointer-events-none absolute -right-10 -top-10 h-44 w-44 rounded-full bg-indigo-500/30 blur-2xl"></div>

            <div class="relative flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
                <div>
                    <h2 class="text-2xl font-extrabold text-white">Ingin melihat penerapan keahlian saya?</h2>
                    <p class="mt-2 max-w-xl text-sm text-slate-300">Setiap keahlian saya terapkan dalam proyek nyata yang bisa dilihat langsung di halaman portofolio.</p>
                </div>
                <a href="{{ route('projects.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-semibold text-slate-900 transition hover:bg-indigo-50">
                    Jelajahi Proyek
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </section>
@endsection
