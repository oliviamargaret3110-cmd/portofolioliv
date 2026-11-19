@props(['certificate'])

@php
    $isAchievement = $certificate->category === 'prestasi';
@endphp

<article class="card-hover group flex flex-col overflow-hidden" data-aos="fade-up">
    <button
        type="button"
        data-lightbox="{{ media_url($certificate->image) }}"
        data-lightbox-alt="Sertifikat {{ $certificate->title }}"
        class="relative block aspect-[4/3] w-full overflow-hidden bg-slate-100 dark:bg-slate-800"
        aria-label="Lihat sertifikat {{ $certificate->title }} dalam ukuran penuh"
        title="Perbesar sertifikat"
    >
        <img
            src="{{ media_url($certificate->image) }}"
            alt="Sertifikat {{ $certificate->title }}"
            loading="lazy"
            class="h-full w-full object-contain p-2 transition duration-300 group-hover:scale-[1.02]"
        >

        <span class="absolute right-3 top-3 inline-flex items-center gap-1.5 rounded-full px-2.5 py-1 text-[11px] font-bold shadow {{ $isAchievement ? 'bg-amber-400 text-amber-950' : 'bg-indigo-600 text-white' }}">
            <i class="fa-solid {{ $isAchievement ? 'fa-trophy' : 'fa-certificate' }}"></i>
            {{ $isAchievement ? 'Prestasi' : 'Sertifikat' }}
        </span>
    </button>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="text-base font-bold leading-snug text-slate-900 dark:text-white">
            {{ $certificate->title }}
        </h3>

        <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
            {{ $certificate->organizer }}
        </p>

        <div class="mt-3 flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400">
            <i class="fa-regular fa-calendar"></i>
            {{ format_date_id($certificate->date) }}
        </div>

        @if ($certificate->description)
            <p class="mt-3 text-xs leading-relaxed text-slate-500 dark:text-slate-400">
                {{ \Illuminate\Support\Str::limit($certificate->description, 100) }}
            </p>
        @endif
    </div>
</article>
