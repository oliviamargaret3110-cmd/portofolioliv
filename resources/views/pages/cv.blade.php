@extends('layouts.app')

@section('title', 'CV Digital')
@section('meta_description', 'CV digital dalam format web, siap dicetak menjadi PDF.')

@section('content')
    <section class="container-page mt-8">
        <div class="no-print flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-extrabold text-slate-900 dark:text-white">CV Digital</h1>
                <p class="text-sm text-slate-500 dark:text-slate-400">Pratinjau CV. Gunakan tombol cetak untuk menyimpan sebagai PDF.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="btn-outline">
                    <i class="fa-solid fa-arrow-left"></i>
                    Beranda
                </a>

                <a href="{{ route('cv.print') }}" target="_blank" rel="noopener" class="btn-primary">
                    <i class="fa-solid fa-print"></i>
                    Cetak / Simpan PDF
                </a>
            </div>
        </div>

        <div class="card print-page mx-auto mt-6 max-w-4xl p-6 sm:p-10">
            <header class="flex flex-col items-center gap-6 border-b border-slate-200 pb-6 text-center sm:flex-row sm:text-left dark:border-slate-800">
                <img
                    src="{{ profile_photo_url($profile?->photo) }}"
                    alt="Foto {{ $profile?->full_name ?? 'profil' }}"
                    class="h-28 w-28 shrink-0 rounded-2xl bg-slate-100 object-cover object-top ring-4 ring-indigo-500/20 dark:bg-slate-800"
                >

                <div class="min-w-0">
                    <h2 class="text-2xl font-extrabold tracking-tight text-slate-900 dark:text-white">
                        {{ $profile?->full_name ?? 'Nama Anda' }}
                    </h2>
                    <p class="mt-1 text-sm font-semibold text-indigo-600 dark:text-indigo-400">
                        {{ $profile?->headline ?? 'Siswa PPLG | Web Developer' }}
                    </p>

                    <div class="mt-3 flex flex-wrap justify-center gap-x-4 gap-y-1 text-xs text-slate-500 sm:justify-start dark:text-slate-400">
                        @if ($profile?->email)
                            <a href="mailto:{{ $profile->email }}" class="inline-flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400"><i class="fa-solid fa-envelope text-[10px]"></i>{{ $profile->email }}</a>
                        @endif
                        @if ($profile?->phone)
                            <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-phone text-[10px]"></i>{{ $profile->phone }}</span>
                        @endif
                        @if ($profile?->location)
                            <span class="inline-flex items-center gap-1.5"><i class="fa-solid fa-location-dot text-[10px]"></i>{{ $profile->location }}</span>
                        @endif
                        @if ($profile?->instagram_url)
                            <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400"><i class="fa-brands fa-instagram text-[10px]"></i>{{ instagram_username($profile->instagram_url) }}</a>
                        @endif
                        @if ($profile?->github_url)
                            <a href="{{ $profile->github_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 hover:text-indigo-600 dark:hover:text-indigo-400"><i class="fa-brands fa-github text-[10px]"></i>GitHub</a>
                        @endif
                    </div>
                </div>
            </header>

            <div class="mt-6 grid gap-8 md:grid-cols-[1.55fr_1fr]">
                <div class="space-y-6">
                    {{-- Data profil contoh dari seeder tidak ditampilkan di CV. --}}
                    @if ($profile?->bio && ! has_placeholder($profile->bio))
                        <section>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Profil</h3>
                            <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{!! nl2br(e($profile->bio)) !!}</p>
                        </section>
                    @endif

                    @if ($experiences->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Pengalaman</h3>
                            <div class="mt-3 space-y-4">
                                @foreach ($experiences as $experience)
                                    <div>
                                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $experience->title }}</p>
                                            @if (filled($experience->start_date))
                                                <p class="text-[11px] font-medium text-slate-400">{{ period_id($experience->start_date, $experience->end_date, $experience->is_current, 'j F Y') }}</p>
                                            @endif
                                        </div>
                                        <p class="text-xs font-medium text-slate-600 dark:text-slate-300">{{ $experience->organization }}{{ $experience->position ? ' - '.$experience->position : '' }}</p>
                                        @if ($experience->description)
                                            <p class="mt-1 text-xs leading-relaxed text-slate-500 dark:text-slate-400">{{ $experience->description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if ($educations->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Pendidikan</h3>
                            <div class="mt-3 space-y-3">
                                @foreach ($educations as $education)
                                    <div>
                                        <div class="flex flex-wrap items-baseline justify-between gap-2">
                                            <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $education->school_name }}</p>
                                            <p class="text-[11px] font-medium text-slate-400">{{ $education->start_year }} &ndash; {{ $education->end_year ?: 'Sekarang' }}</p>
                                        </div>
                                        <p class="text-xs text-slate-600 dark:text-slate-300">{{ $education->level }}{{ $education->major ? ' - '.$education->major : '' }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if ($projects->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Proyek</h3>
                            <div class="mt-3 space-y-3">
                                @foreach ($projects as $project)
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $project->title }}</p>
                                        <p class="text-xs text-slate-600 dark:text-slate-300">{{ $project->category }}{{ $project->technologies ? ' - '.$project->technologies : '' }}</p>
                                        @if ($project->short_description)
                                            <p class="mt-0.5 text-xs leading-relaxed text-slate-500 dark:text-slate-400">{{ $project->short_description }}</p>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <div class="space-y-6">
                    @if ($hardSkills->isNotEmpty() || $softSkills->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Keahlian</h3>

                            <div class="mt-3 space-y-3">
                                @foreach ($hardSkills as $skill)
                                    <div>
                                        <div class="flex items-center justify-between text-xs font-medium text-slate-600 dark:text-slate-300">
                                            <span>{{ $skill->name }}</span>
                                            <span>{{ $skill->percentage }}%</span>
                                        </div>
                                        <div class="mt-1 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                            <div class="h-full rounded-full bg-indigo-500" style="width: {{ max(0, min(100, $skill->percentage)) }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($softSkills->isNotEmpty())
                                <div class="mt-4 flex flex-wrap gap-1.5">
                                    @foreach ($softSkills as $skill)
                                        <span class="rounded-md bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">{{ $skill->name }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </section>
                    @endif

                    @if ($certificates->isNotEmpty())
                        <section>
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-indigo-600 dark:text-indigo-400">Sertifikat</h3>
                            <div class="mt-3 space-y-2">
                                @foreach ($certificates as $certificate)
                                    <div>
                                        <p class="text-xs font-semibold text-slate-900 dark:text-white">{{ $certificate->title }}</p>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $certificate->organizer }} &bull; {{ format_date_id($certificate->date, 'Y') }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </section>
                    @endif

                    @if ($profile?->career_goal && ! has_placeholder($profile->career_goal))
                        <section class="rounded-xl border border-indigo-200 bg-indigo-50 p-4 dark:border-indigo-900 dark:bg-indigo-500/10">
                            <h3 class="text-xs font-extrabold uppercase tracking-widest text-indigo-700 dark:text-indigo-300">Tujuan Karier</h3>
                            <p class="mt-2 text-xs leading-relaxed text-indigo-900/80 dark:text-indigo-200">{{ $profile->career_goal }}</p>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
