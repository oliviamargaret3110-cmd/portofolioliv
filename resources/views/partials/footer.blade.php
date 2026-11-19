@php
    $contactLinks = collect([
        ['label' => 'Email', 'text' => $siteProfile?->email, 'value' => $siteProfile?->email, 'url' => $siteProfile?->email ? 'mailto:'.$siteProfile->email : null, 'icon' => 'fa-solid fa-envelope'],
        ['label' => 'GitHub', 'text' => 'GitHub', 'value' => $siteProfile?->github_url, 'url' => $siteProfile?->github_url, 'icon' => 'fa-brands fa-github'],
        ['label' => 'Instagram', 'text' => instagram_username($siteProfile?->instagram_url) ?: 'Instagram', 'value' => $siteProfile?->instagram_url, 'url' => $siteProfile?->instagram_url, 'icon' => 'fa-brands fa-instagram'],
        ['label' => 'LinkedIn', 'text' => 'LinkedIn', 'value' => $siteProfile?->linkedin_url, 'url' => $siteProfile?->linkedin_url, 'icon' => 'fa-brands fa-linkedin-in'],
    ])->filter(fn (array $item) => filled($item['url']));
@endphp

<footer class="no-print mt-24 border-t border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
    <div class="container-page grid gap-10 py-12 md:grid-cols-3">
        <div>
            <div class="flex items-center gap-3">
                @if ($siteProfile?->photo)
                    <img src="{{ profile_photo_url($siteProfile->photo) }}" alt="Foto {{ $siteProfile->full_name }}" class="h-11 w-11 rounded-full object-cover object-top ring-2 ring-indigo-500/30">
                @else
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-indigo-600 text-sm font-bold text-white">
                        {{ initials($siteProfile?->full_name ?? setting('site_name')) }}
                    </span>
                @endif

                <div>
                    <p class="text-sm font-extrabold text-slate-900 dark:text-white">{{ setting('site_name', config('app.name')) }}</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400">{{ setting('site_tagline', 'Personal Portfolio') }}</p>
                </div>
            </div>

            <p class="mt-4 max-w-sm text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                {{ public_text(setting('site_description', 'Website portofolio pribadi.')) }}
            </p>
        </div>

        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Navigasi</p>
            <div class="mt-4 grid grid-cols-2 gap-2 text-sm">
                <a href="{{ route('about') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Tentang</a>
                <a href="{{ route('skills') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Keahlian</a>
                <a href="{{ route('projects.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Proyek</a>
                <a href="{{ route('certificates.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Sertifikat</a>
                <a href="{{ route('experiences.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Pengalaman</a>
                <a href="{{ route('blog.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Blog</a>
                <a href="{{ route('testimonials.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Testimoni</a>
                <a href="{{ route('contact.index') }}" class="text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">Kontak</a>
            </div>
        </div>

        <div>
            <p class="text-xs font-bold uppercase tracking-widest text-slate-500 dark:text-slate-400">Hubungi</p>

            @if ($contactLinks->isEmpty())
                <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">
                    Informasi kontak belum diisi.
                </p>
            @else
                <div class="mt-4 space-y-2 text-sm">
                    @foreach ($contactLinks as $contact)
                        <a href="{{ $contact['url'] }}" target="{{ str_starts_with($contact['url'], 'http') ? '_blank' : '_self' }}" rel="noopener noreferrer" class="flex items-center gap-3 text-slate-600 transition hover:text-indigo-600 dark:text-slate-400 dark:hover:text-indigo-400">
                            <i class="{{ $contact['icon'] }} w-4 text-center"></i>
                            <span class="truncate">{{ $contact['text'] }}</span>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

    <div class="border-t border-slate-200 py-5 dark:border-slate-800">
        <div class="container-page flex flex-col items-center justify-between gap-2 text-center text-xs text-slate-500 sm:flex-row sm:text-left dark:text-slate-400">
            <p>&copy; {{ date('Y') }} {{ setting('site_name', config('app.name')) }}. {{ setting('footer_text', 'Seluruh hak cipta dilindungi.') }}</p>
            <a href="{{ route('login') }}" class="transition hover:text-indigo-600 dark:hover:text-indigo-400">Login Admin</a>
        </div>
    </div>
</footer>
