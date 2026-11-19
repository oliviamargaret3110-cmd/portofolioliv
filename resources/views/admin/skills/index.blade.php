@extends('layouts.admin')

@section('title', 'Keahlian')
@section('subtitle', 'Kelola hard skill dan soft skill')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Keahlian</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $skills->total() }} keahlian</p>
        </div>

        <a href="{{ route('admin.skills.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Keahlian
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($skills->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-chart-simple mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada keahlian. Tambahkan keahlian pertama Anda.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="table-th">Keahlian</th>
                            <th class="table-th">Kategori</th>
                            <th class="table-th">Persentase</th>
                            <th class="table-th">Urutan</th>
                            <th class="table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($skills as $skill)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="table-td">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                            <i class="{{ $skill->icon ?: 'fa-solid fa-code' }} text-xs"></i>
                                        </span>
                                        <span class="font-semibold text-slate-900 dark:text-white">{{ $skill->name }}</span>
                                    </div>
                                </td>
                                <td class="table-td">
                                    <span class="rounded-full px-2.5 py-1 text-[11px] font-semibold {{ $skill->category === 'hard' ? 'bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-300' : 'bg-violet-50 text-violet-700 dark:bg-violet-500/10 dark:text-violet-300' }}">
                                        {{ $skill->category === 'hard' ? 'Hard Skill' : 'Soft Skill' }}
                                    </span>
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center gap-2">
                                        <div class="h-1.5 w-20 overflow-hidden rounded-full bg-slate-100 dark:bg-slate-800">
                                            <div class="h-full rounded-full bg-indigo-500" style="width: {{ max(0, min(100, $skill->percentage)) }}%"></div>
                                        </div>
                                        <span class="text-xs font-semibold">{{ $skill->percentage }}%</span>
                                    </div>
                                </td>
                                <td class="table-td">{{ $skill->sort_order }}</td>
                                <td class="table-td">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.skills.edit', $skill) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.skills.destroy', $skill) }}" data-confirm="Hapus keahlian {{ $skill->name }}?">
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

    @if ($skills->hasPages())
        <div class="mt-6">{{ $skills->links() }}</div>
    @endif
@endsection
