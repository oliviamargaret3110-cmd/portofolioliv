@extends('layouts.admin')

@section('title', 'Pengaturan')
@section('subtitle', 'Atur identitas dan teks umum website')

@section('content')
    <div class="mx-auto max-w-3xl">
        @include('partials.form-errors')

        <form method="POST" action="{{ route('admin.settings.update') }}">
            @csrf
            @method('PUT')

            <div class="card p-6">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Identitas Website</h2>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">Teks ini tampil pada navbar, footer, dan meta halaman.</p>

                <div class="mt-5 space-y-4">
                    @foreach ($fields as $key => $field)
                        <div>
                            <label for="{{ $key }}" class="label">{{ $field['label'] }}</label>

                            @if ($field['type'] === 'textarea')
                                <textarea id="{{ $key }}" name="{{ $key }}" rows="3" class="input resize-y" placeholder="{{ $field['placeholder'] ?? '' }}">{{ old($key, $settings[$key] ?? '') }}</textarea>
                            @else
                                <input type="text" id="{{ $key }}" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" class="input" placeholder="{{ $field['placeholder'] ?? '' }}">
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Pengaturan
                </button>
            </div>
        </form>

        <div class="card mt-6 p-5">
            <div class="flex items-start gap-3">
                <i class="fa-solid fa-circle-info mt-0.5 text-indigo-500"></i>
                <div class="text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                    <p class="font-semibold text-slate-700 dark:text-slate-200">Catatan</p>
                    <p class="mt-1">Nama website juga dipakai sebagai judul tab browser. Jika kolom dikosongkan, nilai bawaan dari file konfigurasi aplikasi akan digunakan.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
