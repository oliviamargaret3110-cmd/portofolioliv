@extends('layouts.admin')

@section('title', $certificate->exists ? 'Edit Sertifikat' : 'Tambah Sertifikat')
@section('subtitle', $certificate->exists ? 'Perbarui data sertifikat' : 'Tambahkan sertifikat atau prestasi')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('admin.certificates.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        @include('partials.form-errors')

        <form method="POST" action="{{ $certificate->exists ? route('admin.certificates.update', $certificate) : route('admin.certificates.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($certificate->exists)
                @method('PUT')
            @endif

            <div class="card p-6">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Sertifikat</h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="title" class="label">Judul Sertifikat <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $certificate->title) }}" required class="input" placeholder="Contoh: Sertifikat Junior Web Developer">
                    </div>

                    <div>
                        <label for="organizer" class="label">Penerbit <span class="text-rose-500">*</span></label>
                        <input type="text" id="organizer" name="organizer" value="{{ old('organizer', $certificate->organizer) }}" required class="input" placeholder="Contoh: BNSP">
                    </div>

                    <div>
                        <label for="date" class="label">Tanggal <span class="text-rose-500">*</span></label>
                        <input type="date" id="date" name="date" value="{{ old('date', $certificate->date?->format('Y-m-d')) }}" required class="input">
                    </div>

                    <div>
                        <label for="category" class="label">Kategori <span class="text-rose-500">*</span></label>
                        <select id="category" name="category" required class="input">
                            @foreach ($categories as $key => $label)
                                <option value="{{ $key }}" @selected(old('category', $certificate->category) === $key)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="sort_order" class="label">Urutan</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $certificate->sort_order ?? 0) }}" min="0" class="input">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="label">Deskripsi</label>
                        <textarea id="description" name="description" rows="3" class="input resize-y" placeholder="Keterangan singkat sertifikat...">{{ old('description', $certificate->description) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="image" class="label">Gambar Sertifikat</label>
                        <input type="file" id="image" name="image" accept="image/*" class="input file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-300">
                        <p class="mt-1 text-[11px] text-slate-400">JPG/PNG, maksimal 4 MB. {{ $certificate->exists ? 'Biarkan kosong jika tidak ingin mengganti gambar.' : '' }}</p>

                        @if ($certificate->image)
                            <img src="{{ media_url($certificate->image) }}" alt="Gambar saat ini" class="mt-3 h-28 rounded-xl border border-slate-200 object-cover dark:border-slate-800">
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.certificates.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ $certificate->exists ? 'Simpan Perubahan' : 'Simpan Sertifikat' }}
                </button>
            </div>
        </form>
    </div>
@endsection
