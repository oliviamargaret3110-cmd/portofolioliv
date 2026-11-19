@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('subtitle', 'Pesan dari form kontak pengunjung')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Pesan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $messages->total() }} pesan</p>
        </div>

        <span class="badge">
            <i class="fa-solid fa-envelope"></i>
            {{ $messages->getCollection()->where('is_read', false)->count() }} belum dibaca di halaman ini
        </span>
    </div>

    <div class="card overflow-hidden">
        @if ($messages->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-regular fa-envelope-open mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada pesan masuk.</p>
            </div>
        @else
            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @foreach ($messages as $message)
                    <div class="flex flex-wrap items-center gap-4 px-5 py-4 transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <span class="flex h-2.5 w-2.5 shrink-0 rounded-full {{ $message->is_read ? 'bg-slate-300 dark:bg-slate-600' : 'bg-rose-500' }}"></span>

                        <div class="min-w-0 flex-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <p class="text-sm font-bold text-slate-900 dark:text-white">{{ $message->name }}</p>
                                @unless ($message->is_read)
                                    <span class="rounded-full bg-rose-50 px-2 py-0.5 text-[10px] font-bold uppercase tracking-wide text-rose-600 dark:bg-rose-500/10 dark:text-rose-300">Baru</span>
                                @endunless
                                @if ($message->impression)
                                    <span class="text-[11px] text-slate-400">{{ $message->impression }}</span>
                                @endif
                            </div>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $message->email }}</p>
                            <p class="mt-1 line-clamp-1 text-sm text-slate-600 dark:text-slate-300">{{ $message->message }}</p>
                        </div>

                        <div class="shrink-0 text-right">
                            <p class="text-[11px] text-slate-400">{{ $message->created_at->format('d/m/Y H:i') }}</p>

                            <div class="mt-1 flex items-center justify-end gap-1">
                                <a href="{{ route('admin.messages.show', $message) }}" class="btn-ghost px-3 py-1.5 text-xs">
                                    <i class="fa-solid fa-eye"></i>
                                    Buka
                                </a>

                                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" data-confirm="Hapus pesan dari {{ $message->name }}?">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-rose-50 hover:text-rose-600 dark:hover:bg-rose-500/10" title="Hapus pesan">
                                        <i class="fa-solid fa-trash text-xs"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if ($messages->hasPages())
        <div class="mt-6">{{ $messages->links() }}</div>
    @endif
@endsection
