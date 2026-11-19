@extends('layouts.admin')

@section('title', 'Blog')
@section('subtitle', 'Kelola artikel dan catatan')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Artikel</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $posts->total() }} artikel</p>
        </div>

        <a href="{{ route('admin.posts.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tulis Artikel
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($posts->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-pen-nib mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada artikel.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="table-th">Artikel</th>
                            <th class="table-th">Kategori</th>
                            <th class="table-th">Status</th>
                            <th class="table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($posts as $post)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="table-td">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ media_url($post->image) }}" alt="Gambar {{ $post->title }}" class="h-11 w-14 shrink-0 rounded-lg object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-900 dark:text-white">{{ $post->title }}</p>
                                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'Belum dijadwalkan' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-td">{{ $post->category }}</td>
                                <td class="table-td">
                                    @if ($post->published_at && $post->published_at->isPast())
                                        <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-[11px] font-semibold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Terbit</span>
                                    @else
                                        <span class="rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">Draf</span>
                                    @endif
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center justify-end gap-1">
                                        @if ($post->published_at && $post->published_at->isPast())
                                            <a href="{{ route('blog.show', $post) }}" target="_blank" rel="noopener" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800" title="Lihat di website">
                                                <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                            </a>
                                        @endif

                                        <a href="{{ route('admin.posts.edit', $post) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.posts.destroy', $post) }}" data-confirm="Hapus artikel {{ $post->title }}?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-rose-500/10" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    @if ($posts->hasPages())
        <div class="mt-6">{{ $posts->links() }}</div>
    @endif
@endsection
