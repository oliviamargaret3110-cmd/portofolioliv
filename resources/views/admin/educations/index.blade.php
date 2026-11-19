@extends('layouts.admin')

@section('title', 'Pendidikan')
@section('subtitle', 'Kelola riwayat pendidikan')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Riwayat Pendidikan</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $educations->total() }} data</p>
        </div>

        <a href="{{ route('admin.educations.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Pendidikan
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($educations->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-graduation-cap mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada data pendidikan.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="table-th">Sekolah</th>
                            <th class="table-th">Jenjang</th>
                            <th class="table-th">Tahun</th>
                            <th class="table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($educations as $education)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="table-td">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $education->school_name }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $education->major ?: '-' }}</p>
                                </td>
                                <td class="table-td">{{ $education->level }}</td>
                                <td class="table-td">{{ $education->start_year }} &ndash; {{ $education->end_year ?: 'Sekarang' }}</td>
                                <td class="table-td">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.educations.edit', $education) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.educations.destroy', $education) }}" data-confirm="Hapus pendidikan {{ $education->school_name }}?">
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

    @if ($educations->hasPages())
        <div class="mt-6">{{ $educations->links() }}</div>
    @endif
@endsection
