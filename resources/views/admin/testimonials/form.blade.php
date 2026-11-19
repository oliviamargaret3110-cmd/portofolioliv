@extends('layouts.admin')

@section('title', $testimonial->exists ? 'Edit Testimoni' : 'Tambah Testimoni')
@section('subtitle', $testimonial->exists ? 'Perbarui data testimoni' : 'Tambahkan testimoni baru')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('admin.testimonials.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        @include('partials.form-errors')

        <form method="POST" action="{{ $testimonial->exists ? route('admin.testimonials.update', $testimonial) : route('admin.testimonials.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($testimonial->exists)
                @method('PUT')
            @endif

            <div class="card p-6">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Testimoni</h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="label">Nama <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $testimonial->name) }}" required class="input" placeholder="Nama pemberi testimoni">
                    </div>

                    <div>
                        <label for="position" class="label">Jabatan / Keterangan</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $testimonial->position) }}" class="input" placeholder="Contoh: Guru Pembimbing">
                    </div>

                    <div>
                        <label for="category" class="label">Kategori <span class="text-rose-500">*</span></label>
                        <select id="category" name="category" required class="input">
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}" @selected(old('category', $testimonial->category) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort_order" class="label">Urutan</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $testimonial->sort_order ?? 0) }}" min="0" class="input">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="project_id" class="label">Terkait Proyek (opsional)</label>
                        <select id="project_id" name="project_id" class="input">
                            <option value="">Tidak terkait proyek tertentu</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}" @selected((string) old('project_id', $testimonial->project_id) === (string) $project->id)>{{ $project->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="content" class="label">Isi Testimoni <span class="text-rose-500">*</span></label>
                        <textarea id="content" name="content" rows="5" required class="input resize-y" placeholder="Tulis kesan atau masukan...">{{ old('content', $testimonial->content) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="photo" class="label">Foto (opsional)</label>
                        <input type="file" id="photo" name="photo" accept="image/*" class="input file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-300">
                        <p class="mt-1 text-[11px] text-slate-400">JPG/PNG, maksimal 2 MB.</p>

                        @if ($testimonial->photo)
                            <img src="{{ media_url($testimonial->photo) }}" alt="Foto saat ini" class="mt-3 h-20 w-20 rounded-full border border-slate-200 object-cover dark:border-slate-800">
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.testimonials.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ $testimonial->exists ? 'Simpan Perubahan' : 'Simpan Testimoni' }}
                </button>
            </div>
        </form>
    </div>
@endsection
