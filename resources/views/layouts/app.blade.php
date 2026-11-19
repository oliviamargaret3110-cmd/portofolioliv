<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', setting('site_name', config('app.name'))) &mdash; {{ setting('site_tagline', 'Personal Portfolio') }}</title>
    <meta name="description" content="@yield('meta_description', setting('site_description', 'Website portofolio pribadi.'))">

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
<body>
    @include('partials.navbar')

    <main class="page-transition min-h-[70vh]">
        @include('partials.flash')
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.back-to-top')
    @include('partials.lightbox')

    @stack('scripts')
</body>
</html>
