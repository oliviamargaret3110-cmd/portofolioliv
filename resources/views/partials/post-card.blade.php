@props(['post'])

@php
    $excerpt = ($filterPlaceholder ?? false)
        ? public_text($post->excerpt)
        : $post->excerpt;
@endphp

<article class="card-hover group flex flex-col overflow-hidden" data-aos="fade-up">
    <a href="{{ route('blog.show', $post) }}" class="relative block aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
        <img
            src="{{ media_url($post->image) }}"
            alt="Gambar artikel {{ $post->title }}"
            loading="lazy"
            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
        >
    </a>

    <div class="flex flex-1 flex-col p-5">
        <div class="flex items-center gap-2 text-[11px] font-medium text-slate-500 dark:text-slate-400">
            <span class="badge">{{ $post->category }}</span>
            <span>&bull;</span>
            <span>{{ format_date_id($post->published_at, 'd M Y') }}</span>
        </div>

        <h3 class="mt-3 text-base font-bold leading-snug text-slate-900 dark:text-white">
            <a href="{{ route('blog.show', $post) }}" class="transition hover:text-indigo-600 dark:hover:text-indigo-400">
                {{ $post->title }}
            </a>
        </h3>

        <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
            {{ \Illuminate\Support\Str::limit($excerpt, 110) }}
        </p>

        <a href="{{ route('blog.show', $post) }}" class="mt-4 inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 transition hover:gap-2.5 dark:text-indigo-400">
            Baca Artikel
            <i class="fa-solid fa-arrow-right text-[10px]"></i>
        </a>
    </div>
</article>
