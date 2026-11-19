@props(['title', 'category'])

<div {{ $attributes->merge(['class' => 'flex items-center justify-center bg-gradient-to-br from-slate-800 via-indigo-800 to-indigo-600 p-6 text-center']) }}>
    <div class="max-w-sm">
        <p class="text-xs font-semibold uppercase tracking-widest text-indigo-200">{{ $category }}</p>
        <p class="mt-3 text-lg font-bold text-white">{{ $title }}</p>
        <p class="mt-2 text-xs text-white/75">Pratinjau gambar belum tersedia</p>
    </div>
</div>
