@props(['eyebrow', 'title', 'description' => null])

<section class="relative overflow-hidden border-b border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900/40">
    <div class="pointer-events-none absolute -right-16 -top-20 h-64 w-64 rounded-full bg-indigo-500/10 blur-3xl"></div>
    <div class="pointer-events-none absolute -bottom-24 left-1/4 h-56 w-56 rounded-full bg-fuchsia-500/10 blur-3xl"></div>

    <div class="container-page relative py-12 sm:py-16">
        <p class="section-eyebrow">{{ $eyebrow }}</p>
        <h1 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-900 sm:text-4xl lg:text-5xl dark:text-white">
            {{ $title }}
        </h1>

        @if ($description)
            <p class="mt-4 max-w-2xl text-base leading-relaxed text-slate-600 dark:text-slate-400">
                {{ $description }}
            </p>
        @endif

        {{ $slot }}
    </div>
</section>
