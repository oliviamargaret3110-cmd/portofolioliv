@extends('layouts.admin')

@section('title', 'Pengalaman')
@section('subtitle', 'Kelola PLK, organisasi, dan lomba')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Pengalaman</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $experiences->total() }} data</p>
        </div>

        <a href="{{ route('admin.experiences.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Pengalaman
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($experiences->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-briefcase mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada data pengalaman.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="table-th">Pengalaman</th>
                            <th class="table-th">Jenis</th>
                            <th class="table-th">Periode</th>
                            <th class="table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($experiences as $experience)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="table-td">
                                    <p class="font-semibold text-slate-900 dark:text-white">{{ $experience->title }}</p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ $experience->organization }}</p>
                                </td>
                                <td class="table-td">{{ \App\Models\Experience::TYPES[$experience->type] ?? $experience->type }}</td>
                                <td class="table-td">
                                    {{ filled($experience->start_date) ? period_id($experience->start_date, $experience->end_date, $experience->is_current) : ($experience->position ?: '—') }}
                                    @if ($experience->is_current)
                                        <span class="ml-1 rounded-full bg-emerald-50 px-2 py-0.5 text-[10px] font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">Aktif</span>
                                    @endif
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.experiences.edit', $experience) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.experiences.destroy', $experience) }}" data-confirm="Hapus pengalaman {{ $experience->title }}?">
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

    @if ($experiences->hasPages())
        <div class="mt-6">{{ $experiences->links() }}</div>
    @endif
@endsection
