@extends('layouts.app')

@section('title', 'Tentang Saya')
@section('meta_description', $profile?->headline ?? 'Tentang saya')

@section('content')
    <x-page-header eyebrow="Tentang Saya" title="Kenali saya lebih dekat" description="Perjalanan belajar, tujuan karier, dan hal-hal yang saya kerjakan di dunia pengembangan perangkat lunak." />

    <section class="container-page mt-12">
        <div class="grid gap-10 lg:grid-cols-[0.9fr_1.1fr]">
            <div data-aos="fade-right">
                <div class="relative mx-auto max-w-sm">
                    <div class="absolute -inset-3 rounded-[2rem] bg-gradient-to-tr from-indigo-500/20 to-fuchsia-500/20 blur-xl"></div>
                    <img
                        src="{{ profile_photo_url($profile?->photo) }}"
                        alt="Foto {{ $profile?->full_name ?? 'profil' }}"
                        class="relative aspect-[4/5] w-full rounded-[1.8rem] border-4 border-white bg-slate-100 object-cover object-center shadow-xl dark:border-slate-800 dark:bg-slate-800"
                    >
                </div>

                <div class="card mx-auto mt-6 max-w-sm p-5">
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Identitas</p>

                    <dl class="mt-3 space-y-3 text-sm">
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Nama</dt>
                            <dd class="text-right font-semibold text-slate-900 dark:text-white">{{ $profile?->full_name ?? '-' }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Kelas</dt>
                            <dd class="text-right font-semibold text-slate-900 dark:text-white">{{ $profile?->class_name ?? '-' }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Jurusan</dt>
                            <dd class="text-right font-semibold text-slate-900 dark:text-white">{{ $profile?->major ?? '-' }}</dd>
                        </div>
                        <div class="flex items-start justify-between gap-3">
                            <dt class="text-slate-500 dark:text-slate-400">Lokasi</dt>
                            <dd class="text-right font-semibold text-slate-900 dark:text-white">{{ $profile?->location ?? '-' }}</dd>
                        </div>
                    </dl>

                    @if ($profile?->email)
                        <a href="mailto:{{ $profile->email }}" class="btn-primary mt-5 w-full">
                            <i class="fa-solid fa-envelope"></i>
                            Hubungi via Email
                        </a>
                    @endif
                </div>
            </div>

            <div data-aos="fade-left">
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">
                    {{ $profile?->headline ?? 'Siswa PPLG yang sedang belajar web development' }}
                </h2>

                <div class="mt-4 space-y-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    @if ($profile?->bio)
                        {!! nl2br(e($profile->bio)) !!}
                    @else
                        <p>Deskripsi diri belum diisi. Silakan lengkapi melalui Dashboard Admin.</p>
                    @endif
                </div>

                @if ($profile?->career_goal)
                    <div class="mt-6 rounded-2xl border border-indigo-200 bg-indigo-50 p-5 dark:border-indigo-900 dark:bg-indigo-500/10">
                        <p class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-indigo-700 dark:text-indigo-300">
                            <i class="fa-solid fa-bullseye"></i>
                            Tujuan Karier
                        </p>
                        <p class="mt-2 text-sm leading-relaxed text-indigo-900/80 dark:text-indigo-200">
                            {{ $profile->career_goal }}
                        </p>
                    </div>
                @endif

                <div class="mt-8 grid gap-4 sm:grid-cols-2">
                    @foreach ([
                        ['icon' => 'fa-solid fa-graduation-cap', 'label' => 'Pendidikan', 'value' => $educations->first()?->school_name ?? 'Belum diisi'],
                        ['icon' => 'fa-solid fa-briefcase', 'label' => 'Pengalaman', 'value' => $experiences->first()?->title ?? 'Belum diisi'],
                        ['icon' => 'fa-solid fa-chart-simple', 'label' => 'Total Keahlian', 'value' => $skills->count().' keahlian'],
                        ['icon' => 'fa-solid fa-location-dot', 'label' => 'Domisili', 'value' => $profile?->location ?? 'Belum diisi'],
                    ] as $item)
                        <div class="card p-4">
                            <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                <i class="{{ $item['icon'] }} text-sm"></i>
                            </span>
                            <p class="mt-3 text-[11px] font-bold uppercase tracking-widest text-slate-400">{{ $item['label'] }}</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900 dark:text-white">{{ $item['value'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="container-page mt-20">
        <x-section-heading eyebrow="Pendidikan" title="Riwayat pendidikan" description="Jenjang pendidikan formal yang saya tempuh." />

        @if ($educations->isEmpty())
            <div class="card mt-8 p-8 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data pendidikan.</div>
        @else
            <div class="mt-8 space-y-4">
                @foreach ($educations as $education)
                    <div class="card relative overflow-hidden p-6" data-aos="fade-up">
                        <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-indigo-500 to-sky-500"></div>

                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <span class="badge">{{ $education->level }}</span>
                                <h3 class="mt-2 text-lg font-bold text-slate-900 dark:text-white">{{ $education->school_name }}</h3>
                                <p class="text-sm text-slate-500 dark:text-slate-400">{{ $education->major }}</p>
                            </div>
                            <span class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                {{ $education->start_year }} &ndash; {{ $education->end_year ?: 'Sekarang' }}
                            </span>
                        </div>

                        @if ($education->description)
                            <p class="mt-4 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $education->description }}</p>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="container-page mt-20">
        <x-section-heading eyebrow="Keahlian" title="Ringkasan kemampuan" description="Kombinasi hard skill teknis dan soft skill pendukung." />

        <div class="mt-8 grid gap-6 lg:grid-cols-2">
            @foreach ([
                ['title' => 'Hard Skill', 'items' => $skills->where('category', 'hard'), 'icon' => 'fa-solid fa-laptop-code'],
                ['title' => 'Soft Skill', 'items' => $skills->where('category', 'soft'), 'icon' => 'fa-solid fa-people-group'],
            ] as $group)
                <div class="card p-6" data-aos="fade-up">
                    <h3 class="flex items-center gap-2 text-base font-bold text-slate-900 dark:text-white">
                        <i class="{{ $group['icon'] }} text-indigo-500"></i>
                        {{ $group['title'] }}
                    </h3>

                    @if ($group['items']->isEmpty())
                        <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Belum ada data.</p>
                    @else
                        <div class="mt-5 space-y-4">
                            @foreach ($group['items'] as $skill)
                                <div>
                                    <div class="flex items-center justify-between text-xs font-semibold text-slate-600 dark:text-slate-300">
                                        <span class="flex items-center gap-2">
                                            <i class="{{ $skill->icon ?: 'fa-solid fa-code' }} text-[11px] text-slate-400"></i>
                                            {{ $skill->name }}
                                        </span>
                                        <span>{{ $skill->percentage }}%</span>
                                    </div>
                                    <div class="mt-1.5 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                        <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-sky-500" style="width: {{ max(0, min(100, $skill->percentage)) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </section>

    <section class="container-page mt-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <x-section-heading eyebrow="Pengalaman" title="Pengalaman singkat" description="PLK, organisasi, dan lomba yang pernah saya ikuti." />
            <a href="{{ route('experiences.index') }}" class="btn-ghost">
                Selengkapnya
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if ($experiences->isEmpty())
            <div class="card mt-8 p-8 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada data pengalaman.</div>
        @else
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($experiences as $experience)
                    <div class="card p-5" data-aos="fade-up">
                        <div class="flex items-center justify-between gap-3">
                            <span class="badge">{{ \App\Models\Experience::TYPES[$experience->type] ?? $experience->type }}</span>
                            <i class="fa-solid fa-briefcase text-slate-300 dark:text-slate-600"></i>
                        </div>
                        <h3 class="mt-3 text-sm font-bold text-slate-900 dark:text-white">{{ $experience->title }}</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $experience->organization }}</p>
                        <p class="mt-2 text-[11px] font-semibold text-indigo-600 dark:text-indigo-400">
                            {{ filled($experience->start_date) ? period_id($experience->start_date, $experience->end_date, $experience->is_current) : $experience->position }}
                        </p>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="container-page mt-20">
        <div class="flex flex-col items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-white p-8 text-center sm:flex-row sm:text-left dark:border-slate-800 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Tertarik melihat hasil kerja saya?</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Lihat portofolio proyek atau unduh CV digital saya.</p>
            </div>
            <div class="flex flex-wrap justify-center gap-3">
                <a href="{{ route('projects.index') }}" class="btn-primary">Lihat Proyek</a>
                <a href="{{ route('cv.show') }}" class="btn-outline">CV Digital</a>
            </div>
        </div>
    </section>
@endsection
