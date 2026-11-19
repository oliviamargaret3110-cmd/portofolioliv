@extends('layouts.admin')

@section('title', 'Testimoni')
@section('subtitle', 'Kelola testimoni dari guru, teman, pengguna, dan tempat PLK')

@section('content')
    <div class="mb-5 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h2 class="text-lg font-bold text-slate-900 dark:text-white">Daftar Testimoni</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400">Total {{ $testimonials->total() }} testimoni</p>
        </div>

        <a href="{{ route('admin.testimonials.create') }}" class="btn-primary">
            <i class="fa-solid fa-plus"></i>
            Tambah Testimoni
        </a>
    </div>

    <div class="card overflow-hidden">
        @if ($testimonials->isEmpty())
            <div class="p-12 text-center">
                <i class="fa-solid fa-comment-dots mb-3 block text-3xl text-slate-300 dark:text-slate-600"></i>
                <p class="text-sm text-slate-500 dark:text-slate-400">Belum ada testimoni.</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-slate-50 dark:bg-slate-800/50">
                        <tr>
                            <th class="table-th">Pemberi</th>
                            <th class="table-th">Kategori</th>
                            <th class="table-th">Isi</th>
                            <th class="table-th text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach ($testimonials as $testimonial)
                            <tr class="transition hover:bg-slate-50 dark:hover:bg-slate-800/40">
                                <td class="table-td">
                                    <div class="flex items-center gap-3">
                                        @if ($testimonial->photo)
                                            <img src="{{ media_url($testimonial->photo) }}" alt="Foto {{ $testimonial->name }}" class="h-10 w-10 shrink-0 rounded-full object-cover">
                                        @else
                                            <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-100 text-xs font-bold text-indigo-700 dark:bg-indigo-500/20 dark:text-indigo-300">
                                                {{ initials($testimonial->name) }}
                                            </span>
                                        @endif

                                        <div class="min-w-0">
                                            <p class="truncate font-semibold text-slate-900 dark:text-white">{{ $testimonial->name }}</p>
                                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $testimonial->position ?: '-' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="table-td">{{ \App\Models\Testimonial::CATEGORIES[$testimonial->category] ?? $testimonial->category }}</td>
                                <td class="table-td">
                                    <p class="max-w-xs truncate text-xs text-slate-500 dark:text-slate-400">{{ $testimonial->content }}</p>
                                    @if ($testimonial->project)
                                        <p class="mt-0.5 text-[10px] font-medium text-indigo-500">{{ $testimonial->project->title }}</p>
                                    @endif
                                </td>
                                <td class="table-td">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('admin.testimonials.edit', $testimonial) }}" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-400 transition hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-500/10" title="Edit">
                                            <i class="fa-solid fa-pen text-xs"></i>
                                        </a>

                                        <form method="POST" action="{{ route('admin.testimonials.destroy', $testimonial) }}" data-confirm="Hapus testimoni dari {{ $testimonial->name }}?">
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

    @if ($testimonials->hasPages())
        <div class="mt-6">{{ $testimonials->links() }}</div>
    @endif
@endsection
