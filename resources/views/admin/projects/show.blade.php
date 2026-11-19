@extends('layouts.admin')

@section('title', 'Kelola Gambar Proyek')
@section('subtitle', $project->title)

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <a href="{{ route('admin.projects.index') }}" class="btn-ghost -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke daftar proyek
        </a>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener" class="btn-outline">
                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                Lihat di Website
            </a>

            <a href="{{ route('admin.projects.edit', $project) }}" class="btn-primary">
                <i class="fa-solid fa-pen"></i>
                Edit Proyek
            </a>
        </div>
    </div>

    @include('partials.form-errors')

    <div class="grid gap-6 xl:grid-cols-[0.9fr_1.4fr]">
        <div class="space-y-6">
            <div class="card overflow-hidden">
                <img src="{{ media_url($project->thumbnail) }}" alt="Thumbnail {{ $project->title }}" class="aspect-video w-full object-cover">

                <div class="p-5">
                    <span class="badge">{{ $project->category }}</span>
                    <h2 class="mt-2 text-lg font-extrabold text-slate-900 dark:text-white">{{ $project->title }}</h2>
                    <p class="mt-1 text-sm leading-relaxed text-slate-600 dark:text-slate-400">{{ $project->short_description }}</p>

                    @if ($project->technologies)
                        <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">
                            <span class="font-semibold text-slate-700 dark:text-slate-200">Teknologi:</span>
                            {{ $project->technologies }}
                        </p>
                    @endif
                </div>
            </div>

            <div class="card p-5">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Unggah Gambar Dokumentasi</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Gambar tambahan akan tampil di galeri halaman proyek.</p>

                <form method="POST" action="{{ route('admin.projects.images.store', $project) }}" enctype="multipart/form-data" class="mt-4 space-y-4">
                    @csrf

                    <div>
                        <label for="image" class="label">Gambar <span class="text-rose-500">*</span></label>
                        <input type="file" id="image" name="image" accept="image/*" required class="input file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-300">
                        <p class="mt-1 text-[11px] text-slate-400">JPG/PNG, maksimal 4 MB.</p>
                    </div>

                    <div>
                        <label for="caption" class="label">Keterangan</label>
                        <input type="text" id="caption" name="caption" value="{{ old('caption') }}" class="input" placeholder="Contoh: Halaman dashboard admin">
                    </div>

                    <div>
                        <label for="sort_order" class="label">Urutan</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="input">
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        <i class="fa-solid fa-upload"></i>
                        Unggah Gambar
                    </button>
                </form>
            </div>
        </div>

        <div class="card p-5">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Galeri Proyek</h2>
                <span class="badge">{{ $project->images->count() }} gambar</span>
            </div>

            @if ($project->images->isEmpty())
                <div class="mt-6 rounded-2xl border border-dashed border-slate-300 p-10 text-center dark:border-slate-700">
                    <i class="fa-regular fa-images mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                    <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada gambar dokumentasi.</p>
                </div>
            @else
                <div class="mt-4 grid gap-4 sm:grid-cols-2">
                    @foreach ($project->images as $image)
                        <figure class="overflow-hidden rounded-xl border border-slate-200 dark:border-slate-800">
                            <img src="{{ media_url($image->image) }}" alt="{{ $image->caption ?: 'Dokumentasi '.$project->title }}" class="aspect-video w-full object-cover">

                            <figcaption class="flex items-center justify-between gap-2 px-3 py-2">
                                <span class="min-w-0 truncate text-xs text-slate-500 dark:text-slate-400">{{ $image->caption ?: 'Tanpa keterangan' }}</span>

                                <form method="POST" action="{{ route('admin.project-images.destroy', $image) }}" data-confirm="Hapus gambar ini?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-7 w-7 shrink-0 items-center justify-center rounded-lg text-slate-400 transition hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-rose-500/10" title="Hapus gambar">
                                        <i class="fa-solid fa-trash text-[11px]"></i>
                                    </button>
                                </form>
                            </figcaption>
                        </figure>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
