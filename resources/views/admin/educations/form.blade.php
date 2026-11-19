@extends('layouts.admin')

@section('title', $education->exists ? 'Edit Pendidikan' : 'Tambah Pendidikan')
@section('subtitle', $education->exists ? 'Perbarui data pendidikan' : 'Tambahkan riwayat pendidikan')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('admin.educations.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        @include('partials.form-errors')

        <form method="POST" action="{{ $education->exists ? route('admin.educations.update', $education) : route('admin.educations.store') }}">
            @csrf
            @if ($education->exists)
                @method('PUT')
            @endif

            <div class="card p-6">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Pendidikan</h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="level" class="label">Jenjang <span class="text-rose-500">*</span></label>
                        <input type="text" id="level" name="level" value="{{ old('level', $education->level) }}" required class="input" placeholder="Contoh: SMK">
                    </div>

                    <div>
                        <label for="sort_order" class="label">Urutan</label>
                        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $education->sort_order ?? 0) }}" min="0" class="input">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="school_name" class="label">Nama Sekolah <span class="text-rose-500">*</span></label>
                        <input type="text" id="school_name" name="school_name" value="{{ old('school_name', $education->school_name) }}" required class="input" placeholder="Contoh: SMK Negeri 1">
                    </div>

                    <div class="sm:col-span-2">
                        <label for="major" class="label">Jurusan</label>
                        <input type="text" id="major" name="major" value="{{ old('major', $education->major) }}" class="input" placeholder="Contoh: Pengembangan Perangkat Lunak dan Gim">
                    </div>

                    <div>
                        <label for="start_year" class="label">Tahun Mulai <span class="text-rose-500">*</span></label>
                        <input type="number" id="start_year" name="start_year" value="{{ old('start_year', $education->start_year) }}" required min="1900" max="2100" class="input" placeholder="2023">
                    </div>

                    <div>
                        <label for="end_year" class="label">Tahun Selesai</label>
                        <input type="number" id="end_year" name="end_year" value="{{ old('end_year', $education->end_year) }}" min="1900" max="2100" class="input" placeholder="2026">
                        <p class="mt-1 text-[11px] text-slate-400">Kosongkan jika masih berlangsung.</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="label">Deskripsi</label>
                        <textarea id="description" name="description" rows="4" class="input resize-y" placeholder="Kegiatan atau pencapaian selama menempuh pendidikan...">{{ old('description', $education->description) }}</textarea>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.educations.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ $education->exists ? 'Simpan Perubahan' : 'Simpan Pendidikan' }}
                </button>
            </div>
        </form>
    </div>
@endsection
