@extends('layouts.admin')

@section('title', $skill->exists ? 'Edit Keahlian' : 'Tambah Keahlian')
@section('subtitle', $skill->exists ? 'Perbarui data keahlian' : 'Tambahkan keahlian baru')

@section('content')
    <div class="mx-auto max-w-2xl">
        <a href="{{ route('admin.skills.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        @include('partials.form-errors')

        <form method="POST" action="{{ $skill->exists ? route('admin.skills.update', $skill) : route('admin.skills.store') }}">
            @csrf
            @if ($skill->exists)
                @method('PUT')
            @endif

            <div class="card p-6">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Informasi Keahlian</h2>

                <div class="mt-5 space-y-4">
                    <div>
                        <label for="name" class="label">Nama Keahlian <span class="text-rose-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $skill->name) }}" required class="input" placeholder="Contoh: Laravel">
                    </div>

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="category" class="label">Kategori <span class="text-rose-500">*</span></label>
                            <select id="category" name="category" required class="input">
                                <option value="hard" @selected(old('category', $skill->category) === 'hard')>Hard Skill</option>
                                <option value="soft" @selected(old('category', $skill->category) === 'soft')>Soft Skill</option>
                            </select>
                        </div>

                        <div>
                            <label for="percentage" class="label">Persentase (0-100) <span class="text-rose-500">*</span></label>
                            <input type="number" id="percentage" name="percentage" value="{{ old('percentage', $skill->percentage) }}" required min="0" max="100" class="input">
                        </div>

                        <div>
                            <label for="icon" class="label">Ikon Font Awesome</label>
                            <input type="text" id="icon" name="icon" value="{{ old('icon', $skill->icon) }}" class="input" placeholder="fa-brands fa-laravel">
                            <p class="mt-1 text-[11px] text-slate-400">Contoh: fa-brands fa-html5, fa-solid fa-database.</p>
                        </div>

                        <div>
                            <label for="sort_order" class="label">Urutan</label>
                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $skill->sort_order ?? 0) }}" min="0" class="input">
                            <p class="mt-1 text-[11px] text-slate-400">Angka kecil tampil lebih dulu.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.skills.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ $skill->exists ? 'Simpan Perubahan' : 'Simpan Keahlian' }}
                </button>
            </div>
        </form>
    </div>
@endsection
