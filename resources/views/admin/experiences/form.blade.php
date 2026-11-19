@extends('layouts.admin')

@section('title', $experience->exists ? 'Edit Pengalaman' : 'Tambah Pengalaman')
@section('subtitle', $experience->exists ? 'Perbarui data pengalaman' : 'Tambahkan pengalaman baru')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('admin.experiences.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        @include('partials.form-errors')

        <form method="POST" action="{{ $experience->exists ? route('admin.experiences.update', $experience) : route('admin.experiences.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($experience->exists)
                @method('PUT')
            @endif

            <div class="card p-6">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Pengalaman</h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="title" class="label">Judul / Nama Kegiatan <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $experience->title) }}" required class="input" placeholder="Contoh: Praktik Lapangan Kerja di PT Maju Jaya">
                    </div>

                    <div>
                        <label for="organization" class="label">Organisasi / Instansi <span class="text-rose-500">*</span></label>
                        <input type="text" id="organization" name="organization" value="{{ old('organization', $experience->organization) }}" required class="input" placeholder="Contoh: PT Maju Jaya">
                    </div>

                    <div>
                        <label for="position" class="label">Posisi</label>
                        <input type="text" id="position" name="position" value="{{ old('position', $experience->position) }}" class="input" placeholder="Contoh: Web Developer Intern">
                    </div>

                    <div>
                        <label for="type" class="label">Jenis <span class="text-rose-500">*</span></label>
                        <select id="type" name="type" required class="input">
                            @foreach ($types as $key => $label)
                                <option value="{{ $key }}" @selected(old('type', $experience->type) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort_order" class="label">Urutan</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $experience->sort_order ?? 0) }}" min="0" class="input">
                    </div>

                    <div>
                        <label for="start_date" class="label">Tanggal Mulai</label>
                        <input type="date" id="start_date" name="start_date" value="{{ old('start_date', $experience->start_date?->format('Y-m-d')) }}" class="input">
                        <p class="mt-1 text-[11px] text-slate-400">Kosongkan jika periode hanya diketahui sebagai teks, misalnya &ldquo;Saat Kelas XI&rdquo;.</p>
                    </div>

                    <div>
                        <label for="end_date" class="label">Tanggal Selesai</label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date', $experience->end_date?->format('Y-m-d')) }}" class="input">
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600 sm:col-span-2 dark:text-slate-400">
                        <input type="checkbox" name="is_current" value="1" @checked(old('is_current', $experience->is_current)) class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-500 dark:border-slate-700 dark:bg-slate-900">
                        Masih berlangsung (tanggal selesai akan dikosongkan)
                    </label>

                    <div class="sm:col-span-2">
                        <label for="description" class="label">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="input resize-y" placeholder="Tugas, pencapaian, atau hal yang dipelajari...">{{ old('description', $experience->description) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="image" class="label">Gambar Dokumentasi</label>
                        <input type="file" id="image" name="image" accept="image/*" class="input file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-300">
                        <p class="mt-1 text-[11px] text-slate-400">JPG/PNG, maksimal 4 MB.</p>

                        @if ($experience->image)
                            <img src="{{ media_url($experience->image) }}" alt="Gambar saat ini" class="mt-3 h-28 rounded-xl border border-slate-200 object-cover dark:border-slate-800">
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.experiences.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ $experience->exists ? 'Simpan Perubahan' : 'Simpan Pengalaman' }}
                </button>
            </div>
        </form>
    </div>
@endsection
