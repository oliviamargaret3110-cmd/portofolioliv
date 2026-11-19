<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') &mdash; Admin {{ setting('site_name', config('app.name')) }}</title>

    <script>
        (function () {
            const theme = localStorage.getItem('theme');
            if (theme === 'dark' || (!theme && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" referrerpolicy="no-referrer">
    @stack('head')
</head>
<body class="min-h-screen bg-slate-100 dark:bg-slate-950">
    @php
        $adminLinks = [
            ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'match' => 'admin.dashboard', 'icon' => 'fa-solid fa-gauge-high'],
            ['label' => 'Profil', 'route' => 'admin.profile.edit', 'match' => 'admin.profile.*', 'icon' => 'fa-solid fa-user'],
            ['label' => 'Keahlian', 'route' => 'admin.skills.index', 'match' => 'admin.skills.*', 'icon' => 'fa-solid fa-chart-simple'],
            ['label' => 'Pendidikan', 'route' => 'admin.educations.index', 'match' => 'admin.educations.*', 'icon' => 'fa-solid fa-graduation-cap'],
            ['label' => 'Proyek', 'route' => 'admin.projects.index', 'match' => 'admin.projects.*', 'icon' => 'fa-solid fa-layer-group'],
            ['label' => 'Sertifikat', 'route' => 'admin.certificates.index', 'match' => 'admin.certificates.*', 'icon' => 'fa-solid fa-certificate'],
            ['label' => 'Pengalaman', 'route' => 'admin.experiences.index', 'match' => 'admin.experiences.*', 'icon' => 'fa-solid fa-briefcase'],
            ['label' => 'Testimoni', 'route' => 'admin.testimonials.index', 'match' => 'admin.testimonials.*', 'icon' => 'fa-solid fa-comment-dots'],
            ['label' => 'Blog', 'route' => 'admin.posts.index', 'match' => 'admin.posts.*', 'icon' => 'fa-solid fa-pen-nib'],
            ['label' => 'Pesan Masuk', 'route' => 'admin.messages.index', 'match' => 'admin.messages.*', 'icon' => 'fa-solid fa-inbox'],
            ['label' => 'Pengaturan', 'route' => 'admin.settings.edit', 'match' => 'admin.settings.*', 'icon' => 'fa-solid fa-sliders'],
        ];
    @endphp

    <aside id="admin-sidebar" data-mobile-menu class="fixed inset-y-0 left-0 z-50 hidden w-72 flex-col border-r border-slate-200 bg-white lg:flex dark:border-slate-800 dark:bg-slate-900">
        <div class="flex h-16 items-center gap-3 border-b border-slate-200 px-5 dark:border-slate-800">
            <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600 text-sm font-bold text-white">
                {{ initials(auth()->user()->name) }}
            </span>
            <div class="min-w-0">
                <p class="truncate text-sm font-extrabold text-slate-900 dark:text-white">Dashboard Admin</p>
                <p class="truncate text-[11px] text-slate-500 dark:text-slate-400">{{ auth()->user()->email }}</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto p-4">
            @foreach ($adminLinks as $link)
                <a href="{{ route($link['route']) }}" class="admin-link {{ request()->routeIs($link['match']) ? 'admin-link-active' : '' }}">
                    <i class="{{ $link['icon'] }} w-4 text-center"></i>
                    {{ $link['label'] }}
                </a>
            @endforeach
        </nav>

        <div class="space-y-1 border-t border-slate-200 p-4 dark:border-slate-800">
            <a href="{{ route('home') }}" target="_blank" rel="noopener" class="admin-link">
                <i class="fa-solid fa-arrow-up-right-from-square w-4 text-center"></i>
                Lihat Website
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="admin-link w-full text-rose-600 hover:bg-rose-50 hover:text-rose-700 dark:text-rose-400 dark:hover:bg-rose-950/40 dark:hover:text-rose-300">
                    <i class="fa-solid fa-right-from-bracket w-4 text-center"></i>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <div class="lg:ml-72">
        <header class="sticky top-0 z-40 border-b border-slate-200 bg-white/85 backdrop-blur dark:border-slate-800 dark:bg-slate-900/85">
            <div class="flex h-16 items-center justify-between gap-3 px-4 sm:px-6 lg:px-8">
                <div class="flex min-w-0 items-center gap-3">
                    <button type="button" data-mobile-menu-toggle="#admin-sidebar" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 lg:hidden dark:text-slate-300 dark:hover:bg-slate-800" aria-label="Buka menu admin" aria-expanded="false">
                        <i class="fa-solid fa-bars"></i>
                    </button>

                    <div class="min-w-0">
                        <p class="truncate text-sm font-bold text-slate-900 dark:text-white">@yield('title', 'Dashboard')</p>
                        <p class="truncate text-xs text-slate-500 dark:text-slate-400">@yield('subtitle', 'Kelola konten portofolio')</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <button type="button" data-theme-toggle class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="Ganti tema terang/gelap">
                        <i class="fa-solid fa-moon" data-theme-icon="moon"></i>
                        <i class="fa-solid fa-sun hidden" data-theme-icon="sun"></i>
                    </button>

                    <div class="hidden items-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2 sm:flex dark:border-slate-700 dark:bg-slate-800">
                        <i class="fa-solid fa-user-shield text-indigo-600 dark:text-indigo-400"></i>
                        <span class="text-xs font-semibold text-slate-700 dark:text-slate-200">{{ auth()->user()->name }}</span>
                    </div>
                </div>
            </div>
        </header>

        <main class="px-4 py-6 sm:px-6 lg:px-8">
            @include('partials.flash')
            @yield('content')
        </main>
    </div>

    @include('partials.lightbox')
    @stack('scripts')
</body>
</html>
