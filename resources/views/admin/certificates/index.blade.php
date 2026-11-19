@extends('layouts.admin')

@section('title', 'Sertifikat')
@section('subtitle', 'Kelola sertifikat dan prestasi')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Sertifikat</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $certificates->total() }} sertifikat</p>
        </div>

        <a href="{{ route('admin.certificates.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Sertifikat
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($certificates->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-certificate mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada sertifikat.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="table-th">Sertifikat</th>
                            <th class="table-th">Kategori</th>
                            <th class="table-th">Tanggal</th>
                            <th class="table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($certificates as $certificate)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="table-td">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ media_url($certificate->image) }}" alt="Sertifikat {{ $certificate->title }}" class="h-11 w-14 shrink-0 rounded-lg object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-900 dark:text-white">{{ $certificate->title }}</p>
                                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $certificate->organizer }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-td">{{ \App\Models\Certificate::CATEGORIES[$certificate->category] ?? $certificate->category }}</td>
                                <td class="table-td">{{ format_date_id($certificate->date) }}</td>
                                <td class="table-td">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.certificates.edit', $certificate) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.certificates.destroy', $certificate) }}" data-confirm="Hapus sertifikat {{ $certificate->title }}?">
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

    @if ($certificates->hasPages())
        <div class="mt-6">{{ $certificates->links() }}</div>
    @endif
@endsection
