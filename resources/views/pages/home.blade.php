@extends('layouts.app')

@section('title', 'Beranda')
@section('meta_description', $profile?->headline ?? setting('site_description'))

@section('content')
    @php
        $socials = collect([
            ['url' => $profile?->github_url, 'icon' => 'fa-brands fa-github', 'label' => 'GitHub'],
            ['url' => $profile?->instagram_url, 'icon' => 'fa-brands fa-instagram', 'label' => 'Instagram'],
            ['url' => $profile?->linkedin_url, 'icon' => 'fa-brands fa-linkedin-in', 'label' => 'LinkedIn'],
        ])->filter(fn (array $item) => filled($item['url']));
    @endphp

    <section class="relative overflow-hidden">
        <div class="pointer-events-none absolute -left-32 top-0 h-96 w-96 rounded-full bg-indigo-500/10 blur-3xl"></div>
        <div class="pointer-events-none absolute -right-24 bottom-0 h-80 w-80 rounded-full bg-fuchsia-500/10 blur-3xl"></div>

        <div class="container-page relative grid items-center gap-10 py-14 sm:py-16 lg:grid-cols-2 lg:gap-14 lg:py-20">
            <div data-aos="fade-right">
                <span class="badge">
                    <span class="relative flex h-2 w-2">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex h-2 w-2 rounded-full bg-emerald-500"></span>
                    </span>
                    {{ setting('availability_text', 'Terbuka untuk kolaborasi & peluang baru') }}
                </span>

                <h1 class="mt-6 text-4xl font-extrabold leading-tight tracking-tight text-slate-900 sm:text-5xl xl:text-6xl dark:text-white">
                    Halo, saya
                    <span class="bg-gradient-to-r from-indigo-600 via-sky-500 to-fuchsia-500 bg-clip-text text-transparent">
                        {{ $profile?->full_name ?? 'Nama Anda' }}
                    </span>
                </h1>

                <p class="mt-4 text-lg font-semibold text-slate-700 dark:text-slate-200">
                    {{ $profile?->headline ?? 'Siswa PPLG | Web Developer Pemula' }}
                </p>

                <p class="mt-4 max-w-xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                    {{ \Illuminate\Support\Str::limit(public_text($profile?->bio ?? setting('site_description', 'Siswa PPLG yang sedang belajar membangun aplikasi web yang bermanfaat.')), 220) }}
                </p>

                @if ($profile?->class_name || $profile?->major)
                    <div class="mt-5 flex flex-wrap gap-2 text-xs font-medium text-slate-600 dark:text-slate-400">
                        @if ($profile->class_name)
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                                <i class="fa-solid fa-school text-indigo-500"></i>
                                {{ $profile->class_name }}
                            </span>
                        @endif

                        @if ($profile->major)
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                                <i class="fa-solid fa-code text-indigo-500"></i>
                                {{ $profile->major }}
                            </span>
                        @endif

                        @if ($profile->location)
                            <span class="inline-flex items-center gap-1.5 rounded-lg bg-white px-3 py-1.5 shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">
                                <i class="fa-solid fa-location-dot text-indigo-500"></i>
                                {{ $profile->location }}
                            </span>
                        @endif
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap items-center gap-3">
                    <a href="{{ route('projects.index') }}" class="btn-primary">
                        <i class="fa-solid fa-layer-group"></i>
                        Lihat Proyek
                    </a>

                    <a href="{{ route('cv.show') }}" class="btn-outline">
                        <i class="fa-regular fa-file-lines"></i>
                        CV Digital
                    </a>

                    <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-indigo-200 bg-indigo-50 px-5 py-3 text-sm font-semibold text-indigo-700 transition hover:border-indigo-300 hover:bg-indigo-100 focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 dark:border-indigo-500/30 dark:bg-indigo-500/10 dark:text-indigo-300 dark:hover:bg-indigo-500/20 dark:focus-visible:ring-offset-slate-900">
                        <i class="fa-solid fa-envelope"></i>
                        Hubungi Saya
                    </a>
                </div>

                @if ($socials->isNotEmpty())
                    <div class="mt-5 flex items-center gap-1">
                        @foreach ($socials as $social)
                            <a href="{{ $social['url'] }}" target="{{ str_starts_with($social['url'], 'http') ? '_blank' : '_self' }}" rel="noopener noreferrer" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-white hover:text-indigo-600 hover:shadow dark:text-slate-400 dark:hover:bg-slate-900 dark:hover:text-indigo-400" title="{{ $social['label'] }}" aria-label="{{ $social['label'] }}">
                                <i class="{{ $social['icon'] }}"></i>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="relative mx-auto w-full max-w-md" data-aos="fade-left">
                <div class="absolute -inset-4 rounded-[2.5rem] bg-gradient-to-tr from-indigo-500/20 via-sky-400/10 to-fuchsia-500/20 blur-2xl"></div>

                <div class="relative overflow-hidden rounded-[2rem] border border-white/60 bg-white p-2 shadow-2xl shadow-indigo-600/10 dark:border-slate-800 dark:bg-slate-900">
                    <img
                        src="{{ profile_photo_url($profile?->photo) }}"
                        alt="Foto {{ $profile?->full_name ?? 'profil' }}"
                        class="aspect-[3/4] w-full rounded-[1.6rem] bg-slate-100 object-cover object-center dark:bg-slate-800"
                        fetchpriority="high"
                    >
                </div>

                <div class="absolute -bottom-4 left-3 right-3 flex items-center gap-3 rounded-2xl border border-slate-200 bg-white/95 px-4 py-3 shadow-xl backdrop-blur sm:right-auto sm:left-8 dark:border-slate-700 dark:bg-slate-900/95">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-indigo-600 text-white">
                        <i class="fa-solid fa-code"></i>
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-xs font-bold text-slate-900 dark:text-white">{{ $profile?->major ?? 'Pengembangan Perangkat Lunak' }}</p>
                        <p class="truncate text-[11px] text-slate-500 dark:text-slate-400">{{ $profile?->class_name ?? 'SMK PPLG' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container-page">
        <div class="grid grid-cols-2 gap-4 rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:grid-cols-4 sm:p-8 dark:border-slate-800 dark:bg-slate-900" data-aos="fade-up">
            @foreach ([
                ['value' => $counts['projects'], 'label' => 'Proyek', 'icon' => 'fa-solid fa-layer-group'],
                ['value' => $counts['certificates'], 'label' => 'Sertifikat', 'icon' => 'fa-solid fa-certificate'],
                ['value' => $counts['experiences'], 'label' => 'Pengalaman', 'icon' => 'fa-solid fa-briefcase'],
                ['value' => $counts['skills'], 'label' => 'Keahlian', 'icon' => 'fa-solid fa-chart-simple'],
            ] as $stat)
                <div class="text-center sm:text-left">
                    <div class="mx-auto flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 sm:mx-0 dark:bg-indigo-500/10 dark:text-indigo-400">
                        <i class="{{ $stat['icon'] }}"></i>
                    </div>
                    <p class="mt-3 text-2xl font-extrabold text-slate-900 dark:text-white">{{ $stat['value'] }}{{ $stat['value'] > 0 ? '+' : '' }}</p>
                    <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="container-page mt-16 sm:mt-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <x-section-heading eyebrow="Keahlian" title="Keahlian yang saya kembangkan" description="Hard skill dan soft skill yang terus saya kembangkan selama belajar di jurusan PPLG." />

            <a href="{{ route('skills') }}" class="btn-ghost">
                Semua keahlian
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if ($skills->isEmpty())
            <div class="card mt-8 p-8 text-center text-sm text-slate-500 dark:text-slate-400">
                Belum ada keahlian yang ditampilkan.
            </div>
        @else
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($skills as $skill)
                    <div class="card p-5" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                        <div class="flex items-center gap-3">
                            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                <i class="{{ $skill->icon ?: 'fa-solid fa-code' }}"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $skill->name }}</p>
                                <p class="text-[11px] capitalize text-slate-500 dark:text-slate-400">{{ $skill->category }} skill</p>
                            </div>
                        </div>

                        <div class="mt-4 flex items-center justify-between text-xs font-semibold text-slate-500 dark:text-slate-400">
                            <span>Kemampuan</span>
                            <span>{{ $skill->percentage }}%</span>
                        </div>
                        <div class="mt-1.5 h-1.5 w-full overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                            <div class="h-full rounded-full bg-gradient-to-r from-indigo-500 to-sky-500" style="width: {{ max(0, min(100, $skill->percentage)) }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <section class="mt-16 bg-white py-16 sm:mt-20 dark:bg-slate-900/40">
        <div class="container-page">
            <div class="flex flex-wrap items-end justify-between gap-4">
                <x-section-heading eyebrow="Portofolio" title="Proyek pilihan" description="Proyek dan desain media pembelajaran yang saya kerjakan selama belajar di jurusan PPLG." />

                <a href="{{ route('projects.index') }}" class="btn-ghost">
                    Semua proyek
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>

            @if ($projects->isEmpty())
                <div class="card mt-8 p-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    Belum ada proyek yang ditampilkan.
                </div>
            @else
                <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($projects as $project)
                        @include('partials.project-card', ['project' => $project, 'filterPlaceholder' => true])
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="container-page mt-16 grid gap-10 sm:mt-20 lg:grid-cols-2">
        <div>
            <div class="flex items-end justify-between gap-4">
                <x-section-heading eyebrow="Sertifikat" title="Sertifikat & prestasi" />
                <a href="{{ route('certificates.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Lihat semua</a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($certificates as $certificate)
                    <div class="card flex items-center gap-4 p-4" data-aos="fade-up">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                            <i class="fa-solid {{ $certificate->category === 'prestasi' ? 'fa-trophy' : 'fa-certificate' }}"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $certificate->title }}</p>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $certificate->organizer }}</p>
                        </div>
                        <span class="shrink-0 text-[11px] font-medium text-slate-400">{{ format_date_id($certificate->date, 'Y') }}</span>
                    </div>
                @empty
                    <div class="card p-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada sertifikat.</div>
                @endforelse
            </div>
        </div>

        <div>
            <div class="flex items-end justify-between gap-4">
                <x-section-heading eyebrow="Pengalaman" title="Jejak belajar" />
                <a href="{{ route('experiences.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Lihat semua</a>
            </div>

            <div class="mt-6 space-y-3">
                @forelse ($experiences as $experience)
                    <div class="card flex items-start gap-4 p-4" data-aos="fade-up">
                        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-sky-50 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400">
                            <i class="fa-solid fa-briefcase"></i>
                        </span>
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-bold text-slate-900 dark:text-white">{{ $experience->title }}</p>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $experience->organization }}</p>
                            <p class="mt-1 text-[11px] font-medium text-indigo-600 dark:text-indigo-400">
                                {{ filled($experience->start_date) ? period_id($experience->start_date, $experience->end_date, $experience->is_current) : $experience->position }}
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="card p-6 text-center text-sm text-slate-500 dark:text-slate-400">Belum ada pengalaman.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="mt-16 bg-white py-16 sm:mt-20 dark:bg-slate-900/40">
        <div class="container-page">
            <x-section-heading center eyebrow="Testimoni" title="Apa kata mereka" description="Masukan dari guru pembimbing, teman, pengguna, dan tempat PLK." />

            @if ($testimonials->isEmpty())
                <div class="card mx-auto mt-8 max-w-xl p-8 text-center text-sm text-slate-500 dark:text-slate-400">
                    Belum ada testimoni yang ditampilkan.
                </div>
            @else
                <div class="mt-8 grid gap-6 md:grid-cols-3">
                    @foreach ($testimonials as $testimonial)
                        <figure class="card relative p-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 60 }}">
                            <i class="fa-solid fa-quote-left absolute right-5 top-5 text-2xl text-indigo-100 dark:text-indigo-500/20"></i>

                            <blockquote class="text-sm leading-relaxed text-slate-600 dark:text-slate-300">
                                &ldquo;{{ \Illuminate\Support\Str::limit(public_text($testimonial->content), 180) }}&rdquo;
                            </blockquote>

                            <figcaption class="mt-5 flex items-center gap-3 border-t border-slate-100 pt-4 dark:border-slate-800">
                                @if ($testimonial->photo)
                                    <img src="{{ media_url($testimonial->photo) }}" alt="Foto {{ $testimonial->name }}" class="h-10 w-10 rounded-full object-cover">
                                @else
                                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
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
        </div>
    </section>

    <section class="container-page mt-16 sm:mt-20">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <x-section-heading eyebrow="Blog" title="Catatan & artikel terbaru" description="Cerita selama belajar, tutorial singkat, dan hal-hal yang sedang saya pelajari." />

            <a href="{{ route('blog.index') }}" class="btn-ghost">
                Semua artikel
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        @if ($posts->isEmpty())
            <div class="card mt-8 p-8 text-center text-sm text-slate-500 dark:text-slate-400">
                Belum ada artikel yang ditampilkan.
            </div>
        @else
            <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($posts as $post)
                    @include('partials.post-card', ['post' => $post, 'filterPlaceholder' => true])
                @endforeach
            </div>
        @endif
    </section>

    <section class="container-page mt-16 sm:mt-20">
        <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-indigo-600 via-indigo-700 to-fuchsia-700 px-6 py-14 text-center shadow-2xl shadow-indigo-600/20 sm:px-12" data-aos="zoom-in">
            <div class="pointer-events-none absolute -left-10 -top-10 h-40 w-40 rounded-full bg-white/10 blur-2xl"></div>
            <div class="pointer-events-none absolute -bottom-12 -right-8 h-52 w-52 rounded-full bg-white/10 blur-2xl"></div>

            <h2 class="relative text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                Punya pertanyaan atau ingin bekerja sama?
            </h2>
            <p class="relative mx-auto mt-3 max-w-xl text-sm leading-relaxed text-indigo-100 sm:text-base">
                Silakan kirim pesan melalui halaman kontak. Saya akan berusaha membalas secepat mungkin.
            </p>

            <div class="relative mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('contact.index') }}" class="inline-flex items-center justify-center gap-2 rounded-xl bg-white px-6 py-3 text-sm font-semibold text-indigo-700 shadow-lg transition hover:bg-indigo-50">
                    <i class="fa-solid fa-paper-plane"></i>
                    Kirim Pesan
                </a>
                <a href="{{ route('cv.show') }}" class="inline-flex items-center justify-center gap-2 rounded-xl border border-white/30 px-6 py-3 text-sm font-semibold text-white transition hover:bg-white/10">
                    <i class="fa-regular fa-file-lines"></i>
                    Lihat CV
                </a>
            </div>
        </div>
    </section>
@endsection
