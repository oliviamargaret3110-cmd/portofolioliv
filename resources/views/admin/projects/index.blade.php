@extends('layouts.admin')

@section('title', 'Proyek')
@section('subtitle', 'Kelola portofolio proyek')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Proyek</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $projects->total() }} proyek</p>
        </div>

        <a href="{{ route('admin.projects.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Proyek
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($projects->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-layer-group mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada proyek.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="table-th">Proyek</th>
                            <th class="table-th">Kategori</th>
                            <th class="table-th">Gambar</th>
                            <th class="table-th">Unggulan</th>
                            <th class="table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($projects as $project)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="table-td">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ media_url($project->thumbnail) }}" alt="Thumbnail {{ $project->title }}" class="h-11 w-16 shrink-0 rounded-lg object-cover">
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-900 dark:text-white">{{ $project->title }}</p>
                                            <p class="max-w-xs truncate text-xs text-slate-500 dark:text-slate-400">{{ $project->short_description }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-td">{{ $project->category }}</td>
                                <td class="table-td">{{ $project->images_count }} gambar</td>
                                <td class="table-td">
                                    @if ($project->is_featured)
                                        <span class="inline-flex items-center gap-1 rounded-full bg-amber-50 px-2.5 py-1 text-[11px] font-semibold text-amber-700 dark:bg-amber-500/10 dark:text-amber-300">
                                            <i class="fa-solid fa-star text-[9px]"></i>
                                            Ya
                                        </span>
                                    @else
                                        <span class="text-xs text-slate-400">Tidak</span>
                                    @endif
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.projects.show', $project) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800" title="Kelola gambar">
                                            <i class="fa-solid fa-images text-xs"></i>
                                        </a>

                                        <a href="{{ route('admin.projects.edit', $project) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <a href="{{ route('projects.show', $project) }}" target="_blank" rel="noopener" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 dark:hover:bg-slate-800" title="Lihat di website">
                                            <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.projects.destroy', $project) }}" data-confirm="Hapus proyek {{ $project->title }} beserta semua gambarnya?">
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

    @if ($projects->hasPages())
        <div class="mt-6">{{ $projects->links() }}</div>
    @endif
@endsection
