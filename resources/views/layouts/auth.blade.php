<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Login Admin') &mdash; {{ setting('site_name', config('app.name')) }}</title>

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
</head>
<body class="flex min-h-screen items-center justify-center bg-slate-100 px-4 py-10 dark:bg-slate-950">
    <button type="button" data-theme-toggle class="fixed right-5 top-5 inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-600 transition hover:bg-slate-200 dark:text-slate-300 dark:hover:bg-slate-800" aria-label="Ganti tema terang/gelap">
        <i class="fa-solid fa-moon" data-theme-icon="moon"></i>
        <i class="fa-solid fa-sun hidden" data-theme-icon="sun"></i>
    </button>

    <main class="w-full max-w-md">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                <i class="fa-solid fa-arrow-left"></i>
                Kembali ke website
            </a>
        </div>

        <div class="card p-8">
            @include('partials.form-errors')
            @yield('content')
        </div>

        <p class="mt-6 text-center text-xs text-slate-500 dark:text-slate-400">
            &copy; {{ date('Y') }} {{ setting('site_name', config('app.name')) }}
        </p>
    </main>
</body>
</html>
