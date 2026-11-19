@extends('layouts.admin')

@section('title', $post->exists ? 'Edit Artikel' : 'Tulis Artikel')
@section('subtitle', $post->exists ? 'Perbarui artikel blog' : 'Buat artikel blog baru')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('admin.posts.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>

        @include('partials.form-errors')

        <form method="POST" action="{{ $post->exists ? route('admin.posts.update', $post) : route('admin.posts.store') }}" enctype="multipart/form-data">
            @csrf
            @if ($post->exists)
                @method('PUT')
            @endif

            <div class="card p-6">
                <h2 class="text-sm font-bold text-slate-900 dark:text-white">Konten Artikel</h2>

                <div class="mt-5 grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <label for="title" class="label">Judul <span class="text-rose-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title', $post->title) }}" required class="input" placeholder="Judul artikel">
                    </div>

                    <div>
                        <label for="category" class="label">Kategori <span class="text-rose-500">*</span></label>
                        <input type="text" id="category" name="category" value="{{ old('category', $post->category) }}" required class="input" placeholder="Contoh: Tutorial">
                    </div>

                    <div>
                        <label for="published_at" class="label">Tanggal Terbit</label>
                        <input type="datetime-local" id="published_at" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" class="input">
                        <p class="mt-1 text-[11px] text-slate-400">Kosongkan untuk menyimpan sebagai draf.</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="excerpt" class="label">Ringkasan</label>
                        <textarea id="excerpt" name="excerpt" rows="2" class="input resize-y" placeholder="Ringkasan singkat artikel...">{{ old('excerpt', $post->excerpt) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="content" class="label">Isi Artikel <span class="text-rose-500">*</span></label>
                        <textarea id="content" name="content" rows="12" required class="input resize-y" placeholder="Tulis isi artikel di sini...">{{ old('content', $post->content) }}</textarea>
                        <p class="mt-1 text-[11px] text-slate-400">Mendukung teks biasa. Baris baru akan ditampilkan sebagai paragraf baru.</p>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="image" class="label">Gambar Utama</label>
                        <input type="file" id="image" name="image" accept="image/*" class="input file:mr-3 file:rounded-lg file:border-0 file:bg-indigo-50 file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-indigo-700 dark:file:bg-indigo-500/10 dark:file:text-indigo-300">
                        <p class="mt-1 text-[11px] text-slate-400">JPG/PNG, maksimal 4 MB.</p>

                        @if ($post->image)
                            <img src="{{ media_url($post->image) }}" alt="Gambar saat ini" class="mt-3 h-32 rounded-xl border border-slate-200 object-cover dark:border-slate-800">
                        @endif
                    </div>
                </div>
            </div>

            <div class="mt-5 flex justify-end gap-3">
                <a href="{{ route('admin.posts.index') }}" class="btn-outline">Batal</a>
                <button type="submit" class="btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                    {{ $post->exists ? 'Simpan Perubahan' : 'Simpan Artikel' }}
                </button>
            </div>
        </form>
    </div>
@endsection
