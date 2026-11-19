@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('subtitle', 'Pesan dari form kontak')

@section('content')
    <div class="mx-auto max-w-3xl">
        <a href="{{ route('admin.messages.index') }}" class="btn-ghost mb-4 -ml-2">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali ke daftar pesan
        </a>

        <div class="card overflow-hidden">
            <div class="border-b border-slate-100 p-6 dark:border-slate-800">
                <div class="flex flex-wrap items-start justify-between gap-4">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h1 class="text-lg font-extrabold text-slate-900 dark:text-white">{{ $message->name }}</h1>
                            <span class="badge">{{ $message->is_read ? 'Sudah dibaca' : 'Baru' }}</span>
                        </div>
                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $message->email }}</p>
                        @if ($message->impression)
                            <p class="mt-1 text-xs text-slate-400">Kesan/Hubungan: {{ $message->impression }}</p>
                        @endif
                    </div>

                    <div class="text-right text-xs text-slate-400">
                        <p>{{ $message->created_at->format('d/m/Y H:i') }}</p>
                        <p>{{ $message->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>

            <div class="p-6">
                <div class="rounded-2xl bg-slate-50 p-5 text-sm leading-relaxed text-slate-700 dark:bg-slate-800/60 dark:text-slate-200">
                    {!! nl2br(e($message->message)) !!}
                </div>

                <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex flex-wrap gap-2">
                        <a href="mailto:{{ $message->email }}?subject=Balasan%20dari%20{{ urlencode(setting('site_name', config('app.name'))) }}" class="btn-primary">
                            <i class="fa-solid fa-reply"></i>
                            Balas via Email
                        </a>

                        @unless ($message->is_read)
                            <form method="POST" action="{{ route('admin.messages.read', $message) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-outline">
                                    <i class="fa-solid fa-check"></i>
                                    Tandai Dibaca
                                </button>
                            </form>
                        @endunless
                    </div>

                    <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" data-confirm="Hapus pesan dari {{ $message->name }}?">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-danger">
                            <i class="fa-solid fa-trash"></i>
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
