@extends('layouts.app')

@section('title', 'Sertifikat & Prestasi')
@section('meta_description', 'Galeri sertifikat pelatihan, kompetensi, kegiatan, dan prestasi.')

@section('content')
    <x-page-header eyebrow="Pencapaian" title="Sertifikat & prestasi" description="Bukti belajar dan pencapaian yang saya kumpulkan dari pelatihan, uji kompetensi, kegiatan sekolah, dan lomba." />

    <section class="container-page mt-10">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('certificates.index') }}" class="rounded-full px-3.5 py-2 text-xs font-semibold transition {{ $activeCategory === '' ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-indigo-600 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-800' }}">
                    Semua
                </a>

                @foreach ($categories as $key => $label)
                    <a href="{{ route('certificates.index', ['category' => $key, 'q' => $search ?: null]) }}" class="rounded-full px-3.5 py-2 text-xs font-semibold transition {{ $activeCategory === $key ? 'bg-indigo-600 text-white' : 'bg-white text-slate-600 ring-1 ring-slate-200 hover:text-indigo-600 dark:bg-slate-900 dark:text-slate-300 dark:ring-slate-800' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <form method="GET" action="{{ route('certificates.index') }}" class="flex w-full gap-2 lg:w-auto">
                @if ($activeCategory !== '')
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif

                <div class="relative flex-1 lg:w-72">
                    <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400"></i>
                    <input type="search" name="q" value="{{ $search }}" placeholder="Cari sertifikat..." class="input pl-10" aria-label="Cari sertifikat">
                </div>

                <button type="submit" class="btn-primary shrink-0" aria-label="Cari">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        @if ($certificates->isEmpty())
            <div class="card mt-8 p-12 text-center">
                <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-400 dark:bg-slate-800">
                    <i class="fa-solid fa-certificate text-xl"></i>
                </span>
                <h2 class="mt-4 text-lg font-bold text-slate-900 dark:text-white">Belum ada sertifikat</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Sertifikat dengan filter tersebut belum tersedia.</p>
                <a href="{{ route('certificates.index') }}" class="btn-outline mt-5">
                    <i class="fa-solid fa-rotate-left"></i>
                    Tampilkan semua
                </a>
            </div>
        @else
            <p class="mt-6 text-sm text-slate-500 dark:text-slate-400">
                Menampilkan <span class="font-semibold text-slate-900 dark:text-white">{{ $certificates->total() }}</span> sertifikat
            </p>

            <div class="mt-4 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($certificates as $certificate)
                    @include('partials.certificate-card', ['certificate' => $certificate])
                @endforeach
            </div>

            <div class="mt-10">
                {{ $certificates->links() }}
            </div>
        @endif
    </section>
@endsection
