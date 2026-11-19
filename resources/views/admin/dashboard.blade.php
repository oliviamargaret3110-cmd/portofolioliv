@extends('layouts.admin')

@section('title', 'Dashboard')
@section('subtitle', 'Ringkasan konten portofolio')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        @foreach ($stats as $stat)
            <a href="{{ $stat['route'] }}" class="card group p-5 transition hover:-translate-y-0.5 hover:border-indigo-300 hover:shadow-lg dark:hover:border-indigo-700">
                <div class="flex items-center justify-between">
                    <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 transition group-hover:bg-indigo-600 group-hover:text-white dark:bg-indigo-500/10 dark:text-indigo-400">
                        <i class="{{ $stat['icon'] }}"></i>
                    </span>
                    <i class="fa-solid fa-arrow-up-right-from-square text-[11px] text-slate-300 transition group-hover:text-indigo-500 dark:text-slate-600"></i>
                </div>
                <p class="mt-4 text-3xl font-extrabold text-slate-900 dark:text-white">{{ $stat['value'] }}</p>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
            </a>
        @endforeach
    </div>

    <div class="mt-6 grid gap-6 xl:grid-cols-[1.4fr_1fr]">
        <div class="card overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                <div>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Pesan Terbaru</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Pesan dari form kontak pengunjung</p>
                </div>
                <a href="{{ route('admin.messages.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Lihat semua</a>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($recentMessages as $message)
                    <a href="{{ route('admin.messages.show', $message) }}" class="flex items-start gap-3 px-5 py-4 transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <span class="mt-1 flex h-2 w-2 shrink-0 rounded-full {{ $message->is_read ? 'bg-slate-300 dark:bg-slate-600' : 'bg-rose-500' }}"></span>

                        <div class="min-w-0 flex-1">
                            <div class="flex items-center justify-between gap-2">
                                <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $message->name }}</p>
                                <span class="shrink-0 text-[11px] text-slate-400">{{ $message->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="truncate text-xs text-slate-500 dark:text-slate-400">{{ $message->email }}</p>
                            <p class="mt-1 line-clamp-1 text-xs text-slate-600 dark:text-slate-300">{{ $message->message }}</p>
                        </div>
                    </a>
                @empty
                    <div class="px-5 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                        <i class="fa-regular fa-envelope-open mb-2 block text-2xl"></i>
                        Belum ada pesan masuk.
                    </div>
                @endforelse
            </div>
        </div>

        <div class="card overflow-hidden">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4 dark:border-slate-800">
                <div>
                    <h2 class="text-sm font-bold text-slate-900 dark:text-white">Proyek Terbaru</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Proyek yang tampil di website</p>
                </div>
                <a href="{{ route('admin.projects.index') }}" class="text-xs font-semibold text-indigo-600 hover:underline dark:text-indigo-400">Lihat semua</a>
            </div>

            <div class="divide-y divide-slate-100 dark:divide-slate-800">
                @forelse ($recentProjects as $project)
                    <a href="{{ route('admin.projects.edit', $project) }}" class="flex items-center gap-3 px-5 py-3 transition hover:bg-slate-50 dark:hover:bg-slate-800/50">
                        <img src="{{ media_url($project->thumbnail) }}" alt="Thumbnail {{ $project->title }}" class="h-11 w-14 shrink-0 rounded-lg object-cover">
                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $project->title }}</p>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">{{ $project->category }}</p>
                        </div>
                        @if ($project->is_featured)
                            <i class="fa-solid fa-star text-xs text-amber-400"></i>
                        @endif
                    </a>
                @empty
                    <div class="px-5 py-10 text-center text-sm text-slate-500 dark:text-slate-400">
                        <i class="fa-regular fa-folder-open mb-2 block text-2xl"></i>
                        Belum ada proyek.
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="text-sm font-bold text-slate-900 dark:text-white">Aksi Cepat</h2>
        <div class="mt-3 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
            @foreach ([
                ['label' => 'Tambah Proyek', 'route' => 'admin.projects.create', 'icon' => 'fa-solid fa-plus'],
                ['label' => 'Tambah Sertifikat', 'route' => 'admin.certificates.create', 'icon' => 'fa-solid fa-certificate'],
                ['label' => 'Tulis Artikel', 'route' => 'admin.posts.create', 'icon' => 'fa-solid fa-pen-nib'],
                ['label' => 'Edit Profil', 'route' => 'admin.profile.edit', 'icon' => 'fa-solid fa-user'],
            ] as $action)
                <a href="{{ route($action['route']) }}" class="card flex items-center gap-3 p-4 text-sm font-semibold text-slate-700 transition hover:border-indigo-300 hover:text-indigo-600 dark:text-slate-200 dark:hover:border-indigo-700 dark:hover:text-indigo-400">
                    <span class="flex h-9 w-9 items-center justify-center rounded-lg bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                        <i class="{{ $action['icon'] }} text-xs"></i>
                    </span>
                    {{ $action['label'] }}
                </a>
            @endforeach
        </div>
    </div>
@endsection
