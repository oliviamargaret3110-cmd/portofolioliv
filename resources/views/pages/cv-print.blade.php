@extends('layouts.print')

@section('title', 'CV '.($profile?->full_name ?? ''))

@section('content')
    <div class="no-print fixed bottom-5 right-5 z-50 flex gap-2">
        <a href="{{ route('cv.show') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-300 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-lg transition hover:bg-slate-50">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        <button type="button" onclick="window.print()" class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg transition hover:bg-indigo-700">
            <i class="fa-solid fa-print"></i>
            Cetak / Simpan PDF
        </button>
    </div>

    <div class="print-page mx-auto my-8 max-w-[210mm] bg-white p-10 text-slate-800 shadow-xl">
        <header class="flex items-start gap-6 border-b-2 border-indigo-600 pb-5">
            <img
                src="{{ profile_photo_url($profile?->photo) }}"
                alt="Foto {{ $profile?->full_name ?? 'profil' }}"
                class="h-24 w-24 shrink-0 rounded-lg object-cover object-top"
            >

            <div class="min-w-0 flex-1">
                <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
                    {{ $profile?->full_name ?? 'Nama Anda' }}
                </h1>
                <p class="mt-0.5 text-sm font-semibold text-indigo-700">
                    {{ $profile?->headline ?? 'Siswa PPLG | Web Developer' }}
                </p>

                <div class="mt-2 flex flex-wrap gap-x-4 gap-y-1 text-[11px] text-slate-600">
                    @if ($profile?->email)
                        <a href="mailto:{{ $profile->email }}" class="text-slate-600"><i class="fa-solid fa-envelope mr-1 text-[10px]"></i>{{ $profile->email }}</a>
                    @endif
                    @if ($profile?->phone)
                        <span><i class="fa-solid fa-phone mr-1 text-[10px]"></i>{{ $profile->phone }}</span>
                    @endif
                    @if ($profile?->location)
                        <span><i class="fa-solid fa-location-dot mr-1 text-[10px]"></i>{{ $profile->location }}</span>
                    @endif
                    @if ($profile?->instagram_url)
                        <a href="{{ $profile->instagram_url }}" target="_blank" rel="noopener noreferrer" class="text-slate-600"><i class="fa-brands fa-instagram mr-1 text-[10px]"></i>{{ instagram_username($profile->instagram_url) }}</a>
                    @endif
                    @if ($profile?->github_url)
                        <span><i class="fa-brands fa-github mr-1 text-[10px]"></i>{{ $profile->github_url }}</span>
                    @endif
                </div>
            </div>
        </header>

        <div class="mt-5 grid grid-cols-[1.55fr_1fr] gap-8">
            <div class="space-y-5">
                {{-- Data profil contoh dari seeder tidak ditampilkan di CV. --}}
                @if ($profile?->bio && ! has_placeholder($profile->bio))
                    <section>
                        <h2 class="border-b border-slate-300 pb-1 text-[11px] font-extrabold uppercase tracking-widest text-indigo-700">Profil</h2>
                        <p class="mt-2 text-[11.5px] leading-relaxed text-slate-700">{!! nl2br(e($profile->bio)) !!}</p>
                    </section>
                @endif

                @if ($experiences->isNotEmpty())
                    <section>
                        <h2 class="border-b border-slate-300 pb-1 text-[11px] font-extrabold uppercase tracking-widest text-indigo-700">Pengalaman</h2>
                        <div class="mt-2 space-y-3">
                            @foreach ($experiences as $experience)
                                <div>
                                    <div class="flex flex-wrap items-baseline justify-between gap-2">
                                        <p class="text-[12px] font-bold text-slate-900">{{ $experience->title }}</p>
                                        @if (filled($experience->start_date))
                                            <p class="shrink-0 text-[10px] font-medium text-slate-500">{{ period_id($experience->start_date, $experience->end_date, $experience->is_current, 'j F Y') }}</p>
                                        @endif
                                    </div>
                                    <p class="text-[11px] font-medium text-slate-600">{{ $experience->organization }}{{ $experience->position ? ' - '.$experience->position : '' }}</p>
                                    @if ($experience->description)
                                        <p class="mt-0.5 text-[11px] leading-relaxed text-slate-600">{{ $experience->description }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if ($educations->isNotEmpty())
                    <section>
                        <h2 class="border-b border-slate-300 pb-1 text-[11px] font-extrabold uppercase tracking-widest text-indigo-700">Pendidikan</h2>
                        <div class="mt-2 space-y-2">
                            @foreach ($educations as $education)
                                <div class="flex items-baseline justify-between gap-2">
                                    <div>
                                        <p class="text-[12px] font-bold text-slate-900">{{ $education->school_name }}</p>
                                        <p class="text-[11px] text-slate-600">{{ $education->level }}{{ $education->major ? ' - '.$education->major : '' }}</p>
                                    </div>
                                    <p class="shrink-0 text-[10px] font-medium text-slate-500">{{ $education->start_year }} &ndash; {{ $education->end_year ?: 'Sekarang' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if ($projects->isNotEmpty())
                    <section>
                        <h2 class="border-b border-slate-300 pb-1 text-[11px] font-extrabold uppercase tracking-widest text-indigo-700">Proyek</h2>
                        <div class="mt-2 space-y-2">
                            @foreach ($projects as $project)
                                <div>
                                    <p class="text-[12px] font-bold text-slate-900">{{ $project->title }}</p>
                                    <p class="text-[10.5px] text-slate-600">{{ $project->category }}{{ $project->technologies ? ' - '.$project->technologies : '' }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif
            </div>

            <div class="space-y-5">
                @if ($hardSkills->isNotEmpty() || $softSkills->isNotEmpty())
                    <section>
                        <h2 class="border-b border-slate-300 pb-1 text-[11px] font-extrabold uppercase tracking-widest text-indigo-700">Keahlian</h2>
                        <div class="mt-2 space-y-2">
                            @foreach ($hardSkills as $skill)
                                <div>
                                    <div class="flex items-center justify-between text-[11px] font-medium text-slate-700">
                                        <span>{{ $skill->name }}</span>
                                        <span>{{ $skill->percentage }}%</span>
                                    </div>
                                    <div class="mt-0.5 h-1 w-full rounded-full bg-slate-200">
                                        <div class="h-1 rounded-full bg-indigo-600" style="width: {{ max(0, min(100, $skill->percentage)) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if ($softSkills->isNotEmpty())
                            <div class="mt-3 flex flex-wrap gap-1">
                                @foreach ($softSkills as $skill)
                                    <span class="rounded bg-slate-100 px-1.5 py-0.5 text-[10px] font-medium text-slate-700">{{ $skill->name }}</span>
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endif

                @if ($certificates->isNotEmpty())
                    <section>
                        <h2 class="border-b border-slate-300 pb-1 text-[11px] font-extrabold uppercase tracking-widest text-indigo-700">Sertifikat</h2>
                        <div class="mt-2 space-y-2">
                            @foreach ($certificates as $certificate)
                                <div>
                                    <p class="text-[11px] font-semibold text-slate-900">{{ $certificate->title }}</p>
                                    <p class="text-[10px] text-slate-600">{{ $certificate->organizer }} &bull; {{ format_date_id($certificate->date, 'Y') }}</p>
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                @if ($profile?->career_goal && ! has_placeholder($profile->career_goal))
                    <section>
                        <h2 class="border-b border-slate-300 pb-1 text-[11px] font-extrabold uppercase tracking-widest text-indigo-700">Tujuan Karier</h2>
                        <p class="mt-2 text-[11px] leading-relaxed text-slate-700">{{ $profile->career_goal }}</p>
                    </section>
                @endif
            </div>
        </div>

        <footer class="mt-6 border-t border-slate-200 pt-2 text-center text-[9px] text-slate-400">
            CV ini dibuat melalui {{ setting('site_name', config('app.name')) }} &bull; {{ format_date_id(now()) }}
        </footer>
    </div>
@endsection

@push('scripts')
    <script>
        window.addEventListener('load', () => {
            window.setTimeout(() => window.print(), 400);
        });
    </script>
@endpush
