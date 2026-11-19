@props(['project'])

@php
    $technologies = collect(explode(',', (string) $project->technologies))
        ->map(fn (string $item) => trim($item))
        ->filter()
        ->take(4);

    $description = ($filterPlaceholder ?? false)
        ? public_text($project->short_description)
        : $project->short_description;
@endphp

<article class="card-hover group flex flex-col overflow-hidden" data-aos="fade-up">
    <a href="{{ route('projects.show', $project) }}" class="relative block aspect-video overflow-hidden bg-slate-100 dark:bg-slate-800">
        @if (filled($project->thumbnail) && ! str_starts_with($project->thumbnail, 'seed/'))
            <img
                src="{{ media_url($project->thumbnail) }}"
                alt="Thumbnail proyek {{ $project->title }}"
                loading="lazy"
                class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
            >
        @else
            <x-project-placeholder :title="$project->title" :category="$project->category ?? 'Proyek'" class="h-full w-full" />
        @endif

        @if ($project->is_featured)
            <span class="absolute left-3 top-3 inline-flex items-center gap-1.5 rounded-full bg-amber-400 px-2.5 py-1 text-[11px] font-bold text-amber-950 shadow">
                <i class="fa-solid fa-star"></i>
                Unggulan
            </span>
        @endif
    </a>

    <div class="flex flex-1 flex-col p-5">
        <span class="badge w-fit">{{ $project->category }}</span>

        <h3 class="mt-3 text-lg font-bold text-slate-900 dark:text-white">
            <a href="{{ route('projects.show', $project) }}" class="transition hover:text-indigo-600 dark:hover:text-indigo-400">
                {{ $project->title }}
            </a>
        </h3>

        <p class="mt-2 flex-1 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
            {{ \Illuminate\Support\Str::limit($description, 120) }}
        </p>

        @if ($technologies->isNotEmpty())
            <div class="mt-4 flex flex-wrap gap-1.5">
                @foreach ($technologies as $technology)
                    <span class="rounded-md bg-slate-100 px-2 py-1 text-[11px] font-medium text-slate-600 dark:bg-slate-800 dark:text-slate-300">
                        {{ $technology }}
                    </span>
                @endforeach
            </div>
        @endif

        <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4 dark:border-slate-800">
            <a href="{{ route('projects.show', $project) }}" class="inline-flex items-center gap-1.5 text-xs font-semibold text-indigo-600 transition hover:gap-2.5 dark:text-indigo-400">
                Lihat detail
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>

            <div class="flex items-center gap-1">
                @if ($project->demo_url)
                    <a href="{{ $project->demo_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-400 dark:hover:bg-indigo-500/10 dark:hover:text-indigo-400" title="Lihat demo">
                        <i class="fa-solid fa-arrow-up-right-from-square text-xs"></i>
                    </a>
                @endif

                @if ($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-8 w-8 items-center justify-center rounded-lg text-slate-500 transition hover:bg-indigo-50 hover:text-indigo-600 dark:text-slate-400 dark:hover:bg-indigo-500/10 dark:hover:text-indigo-400" title="Repositori GitHub">
                        <i class="fa-brands fa-github text-sm"></i>
                    </a>
                @endif
            </div>
        </div>
    </div>
</article>
