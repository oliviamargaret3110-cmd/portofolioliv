@extends('layouts.app')

@section('title', 'Pengalaman')
@section('meta_description', 'Pengalaman PLK, organisasi, dan lomba.')

@section('content')
    <x-page-header eyebrow="Pengalaman" title="Jejak belajar & berkarya" description="Pengalaman Praktik Lapangan Kerja (PLK), organisasi sekolah, dan lomba yang membentuk cara saya bekerja." />

    <section class="container-page mt-12">
        @if ($experiences->isEmpty())
            <div class="card p-12 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <i class="fa-solid fa-briefcase text-xl"></i>
                </span>
                <h2 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Belum ada pengalaman</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Data pengalaman akan tampil di sini setelah ditambahkan.</p>
            </div>
        @else
            <div class="relative mx-auto max-w-4xl">
                <div class="absolute bottom-0 left-5 top-0 w-px bg-slate-200 sm:left-1/2 dark:bg-slate-800"></div>

                <div class="space-y-8">
                    @foreach ($experiences as $experience)
                        <div class="relative grid gap-4 sm:grid-cols-2 sm:gap-10" data-aos="fade-up">
                            <div class="{{ $loop->odd ? 'pl-10 sm:pr-10 sm:pl-0 sm:text-right' : 'pl-10 sm:col-start-2 sm:pl-10' }}">
                                <div class="card p-5 sm:p-6">
                                    <div class="flex flex-wrap items-center gap-2 {{ $loop->odd ? 'sm:justify-end' : '' }}">
                                        <span class="badge">{{ $types[$experience->type] ?? $experience->type }}</span>
                                        @if ($experience->is_current)
                                            <span class="inline-flex items-center gap-1 rounded-full bg-emerald-100 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                                Aktif
                                            </span>
                                        @endif
                                    </div>

                                    <h2 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">{{ $experience->title }}</h2>
                                    <p class="text-sm font-medium text-slate-600 dark:text-slate-300">{{ $experience->organization }}</p>

                                    @if ($experience->position)
                                        <p class="text-xs text-slate-500 dark:text-slate-400">{{ $experience->position }}</p>
                                    @endif

                                    @if (filled($experience->start_date))
                                        <p class="mt-3 inline-flex items-center gap-1.5 rounded-lg bg-slate-100 px-2.5 py-1 text-[11px] font-semibold text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ period_id($experience->start_date, $experience->end_date, $experience->is_current) }}
                                        </p>
                                    @endif

                                    @if ($experience->description)
                                        <p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $experience->description }}</p>
                                    @endif

                                    @if ($experience->image)
                                        <button
                                            type="button"
                                            data-lightbox="{{ media_url($experience->image) }}"
                                            data-lightbox-alt="Dokumentasi {{ $experience->title }}"
                                            class="mt-4 block w-full overflow-hidden rounded-xl bg-slate-100 dark:bg-slate-800"
                                            title="Perbesar dokumentasi"
                                        >
                                            <img src="{{ media_url($experience->image) }}" alt="Dokumentasi {{ $experience->title }}" loading="lazy" class="aspect-video w-full object-cover transition duration-500 hover:scale-105">
                                        </button>
                                    @endif
                                </div>
                            </div>

                            <div class="absolute left-5 top-6 flex h-4 w-4 -translate-x-1/2 items-center justify-center sm:left-1/2">
                                <span class="h-4 w-4 rounded-full border-4 border-white bg-indigo-600 shadow dark:border-slate-950"></span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <section class="container-page mt-16">
        <div class="flex flex-col items-center justify-between gap-4 rounded-3xl border border-slate-200 bg-white p-8 text-center sm:flex-row sm:text-left dark:border-slate-800 dark:bg-slate-900">
            <div>
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Ingin tahu lebih lengkap?</h2>
                <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">Lihat riwayat lengkap dalam format CV digital.</p>
            </div>
            <a href="{{ route('cv.show') }}" class="btn-primary">
                <i class="fa-regular fa-file-lines"></i>
                Buka CV Digital
            </a>
        </div>
    </section>
@endsection
