@php
    $navLinks = [
        ['label' => 'Beranda', 'route' => 'home', 'match' => 'home'],
        ['label' => 'Tentang', 'route' => 'about', 'match' => 'about'],
        ['label' => 'Keahlian', 'route' => 'skills', 'match' => 'skills'],
        ['label' => 'Proyek', 'route' => 'projects.index', 'match' => 'projects.*'],
        ['label' => 'Sertifikat', 'route' => 'certificates.index', 'match' => 'certificates.*'],
        ['label' => 'Pengalaman', 'route' => 'experiences.index', 'match' => 'experiences.*'],
        ['label' => 'Blog', 'route' => 'blog.index', 'match' => 'blog.*'],
        ['label' => 'Testimoni', 'route' => 'testimonials.index', 'match' => 'testimonials.*'],
        ['label' => 'Kontak', 'route' => 'contact.index', 'match' => 'contact.*'],
    ];
@endphp

<header class="no-print sticky top-0 z-50 border-b border-slate-200/80 bg-white/85 backdrop-blur dark:border-slate-800/80 dark:bg-slate-950/85">
    <nav class="container-page flex h-16 items-center justify-between gap-4">
        <a href="{{ route('home') }}" class="flex min-w-0 items-center gap-3">
            @if ($siteProfile?->photo)
                <img src="{{ profile_photo_url($siteProfile->photo) }}" alt="Foto {{ $siteProfile->full_name }}" class="h-10 w-10 shrink-0 rounded-full object-cover object-top ring-2 ring-indigo-500/30">
            @else
                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">
                    {{ initials($siteProfile?->full_name ?? setting('site_name')) }}
                </span>
            @endif

            <span class="flex min-w-0 flex-col">
                <span class="truncate text-sm font-extrabold text-slate-900 dark:text-white">
                    {{ setting('site_name', config('app.name')) }}
                </span>
                <span class="truncate text-[11px] font-medium text-slate-500 dark:text-slate-400">
                    {{ setting('site_tagline', 'Personal Portfolio') }}
                </span>
            </span>
        </a>

        <div class="hidden items-center gap-1 xl:flex">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" class="nav-link {{ request()->routeIs($link['match']) ? 'nav-link-active' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('cv.show') }}" class="hidden items-center gap-2 rounded-xl border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-indigo-400 hover:text-indigo-600 sm:inline-flex dark:border-slate-700 dark:text-slate-200 dark:hover:border-indigo-500 dark:hover:text-indigo-400">
                <i class="fa-regular fa-file-lines"></i>
                CV
            </a>

            <button type="button" data-theme-toggle class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 dark:text-slate-300 dark:hover:bg-slate-800 dark:focus-visible:ring-offset-slate-950" aria-label="Ganti tema terang/gelap">
                <i class="fa-solid fa-moon" data-theme-icon="moon"></i>
                <i class="fa-solid fa-sun hidden" data-theme-icon="sun"></i>
            </button>

            <button type="button" data-mobile-menu-toggle="#mobile-menu" aria-controls="mobile-menu" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 xl:hidden dark:text-slate-300 dark:hover:bg-slate-800 dark:focus-visible:ring-offset-slate-950" aria-label="Buka menu" aria-expanded="false">
                <i class="fa-solid fa-bars" data-menu-open-icon></i>
                <i class="fa-solid fa-xmark hidden" data-menu-close-icon></i>
            </button>
        </div>
    </nav>

    <div id="mobile-menu" data-mobile-menu class="hidden border-t border-slate-200 bg-white px-4 pb-4 pt-2 xl:hidden dark:border-slate-800 dark:bg-slate-950">
        <div class="grid grid-cols-2 gap-1">
            @foreach ($navLinks as $link)
                <a href="{{ route($link['route']) }}" class="nav-link {{ request()->routeIs($link['match']) ? 'nav-link-active' : '' }}">
                    {{ $link['label'] }}
                </a>
            @endforeach
            <a href="{{ route('cv.show') }}" class="nav-link {{ request()->routeIs('cv.*') ? 'nav-link-active' : '' }}">
                CV Digital
            </a>
        </div>
    </div>
</header>
