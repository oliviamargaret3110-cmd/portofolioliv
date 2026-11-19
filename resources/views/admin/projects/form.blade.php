@extends('layouts.admin')

@section('title', $project->exists ? 'Edit Proyek' : 'Tambah Proyek')
@section('subtitle', $project->exists ? 'Perbarui data proyek' : 'Tambahkan proyek baru')

@section('content')
    <div class="mx-auto max-w-4xl">
        <a href="{{ route('admin.projects.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        @include('partials.form-errors')

        <form method="POST" action="{{ $project->exists ? route('admin.projects.update', $project) : route('admin.projects.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($project->exists)
                @method('PUT')
            @endif

            <div class="space-y-6">
                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Utama</h2>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="title" class="label">Judul Proyek <span class="text-rose-500">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title', $project->title) }}" required class="input" placeholder="Contoh: Aplikasi Kasir Sederhana">
                        </div>

                        <div>
                            <label for="category" class="label">Kategori <span class="text-rose-500">*</span></label>
                            <input type="text" id="category" name="category" value="{{ old('category', $project->category) }}" required class="input" placeholder="Contoh: Web App">
                        </div>

                        <div>
                            <label for="role" class="label">Peran</label>
                            <input type="text" id="role" name="role" value="{{ old('role', $project->role) }}" class="input" placeholder="Contoh: Full Stack Developer">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="short_description" class="label">Deskripsi Singkat <span class="text-rose-500">*</span></label>
                            <textarea id="short_description" name="short_description" rows="2" required maxlength="255" class="input resize-y" placeholder="Ringkasan proyek untuk kartu portofolio...">{{ old('short_description', $project->short_description) }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="technologies" class="label">Teknologi</label>
                            <input type="text" id="technologies" name="technologies" value="{{ old('technologies', $project->technologies) }}" class="input" placeholder="Laravel, MySQL, Tailwind CSS">
                            <p class="mt-1 text-[11px] text-slate-400">Pisahkan dengan koma.</p>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Detail Proyek</h2>

                    <div class="mt-5 space-y-4">
                        <div>
                            <label for="description" class="label">Deskripsi Lengkap</label>
                            <textarea id="description" name="description" rows="5" class="input resize-y" placeholder="Penjelasan lengkap mengenai proyek...">{{ old('description', $project->description) }}</textarea>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2">
                            <div>
                                <label for="problem" class="label">Masalah yang Diselesaikan</label>
                                <textarea id="problem" name="problem" rows="4" class="input resize-y" placeholder="Masalah apa yang ingin dipecahkan?">{{ old('problem', $project->problem) }}</textarea>
                            </div>

                            <div>
                                <label for="goal" class="label">Tujuan Proyek</label>
                                <textarea id="goal" name="goal" rows="4" class="input resize-y" placeholder="Apa tujuan dari proyek ini?">{{ old('goal', $project->goal) }}</textarea>
                            </div>
                        </div>

                        <div>
                            <label for="features" class="label">Fitur Utama</label>
                            <textarea id="features" name="features" rows="5" class="input resize-y" placeholder="Satu fitur per baris:&#10;Login admin&#10;Manajemen produk&#10;Laporan penjualan">{{ old('features', $project->features) }}</textarea>
                            <p class="mt-1 text-[11px] text-slate-400">Tulis satu fitur per baris.</p>
                        </div>

                        <div>
                            <label for="documentation" class="label">Dokumentasi / Catatan</label>
                            <textarea id="documentation" name="documentation" rows="4" class="input resize-y" placeholder="Catatan teknis, cara menjalankan, atau tautan dokumentasi...">{{ old('documentation', $project->documentation) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card p-6">
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Tautan & Media</h2>

                    <div class="mt-5 grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="demo_url" class="label">URL Demo</label>
                            <input type="url" id="demo_url" name="demo_url" value="{{ old('demo_url', $project->demo_url) }}" class="input" placeholder="https://demo.example.com">
                        </div>

                        <div>
                            <label for="github_url" class="label">URL GitHub</label>
                            <input type="url" id="github_url" name="github_url" value="{{ old('github_url', $project->github_url) }}" class="input" placeholder="https://github.com/username/repo">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="thumbnail" class="label">Thumbnail</label>
                            <input type="file" id="thumbnail" name="thumbnail" accept="image/*" class="input file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-300">
                            <p class="mt-1 text-[11px] text-slate-400">JPG/PNG, maksimal 4 MB.</p>

                            @if ($project->thumbnail)
                                <img src="{{ media_url($project->thumbnail) }}" alt="Thumbnail saat ini" class="mt-3 h-32 rounded-xl border border-slate-200 object-cover dark:border-slate-800">
                            @endif
                        </div>

                        <div>
                            <label for="sort_order" class="label">Urutan</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $project->sort_order ?? 0) }}" min="0" class="input">
                        </div>

                        <label class="flex items-center gap-2 self-end pb-2.5 text-sm text-slate-600 dark:text-slate-400">
                            <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured)) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900">
                            Tandai sebagai proyek unggulan
                        </label>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.projects.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ $project->exists ? 'Simpan Perubahan' : 'Simpan Proyek' }}
                </button>
            </div>
        </form>
    </div>
@endsection
