@extends('layouts.app')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi saya melalui form pesan atau media sosial.')

@section('content')
    <x-page-header eyebrow="Kontak" title="Mari terhubung" description="Punya pertanyaan, tawaran kerja sama, atau ingin memberi masukan? Kirimkan pesan melalui form di bawah ini." />

    <section class="container-page mt-12">
        <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900 dark:text-white">Informasi kontak</h2>
                <p class="mt-2 text-sm leading-relaxed text-slate-600 dark:text-slate-400">
                    Saya biasanya membalas pesan dalam 1&ndash;2 hari. Untuk keperluan cepat, silakan hubungi melalui email atau media sosial.
                </p>

                @php
                    $contactItems = collect([
                        ['icon' => 'fa-solid fa-envelope', 'label' => 'Email', 'value' => $profile?->email, 'url' => $profile?->email ? 'mailto:'.$profile->email : null],
                        ['icon' => 'fa-brands fa-instagram', 'label' => 'Instagram', 'value' => instagram_username($profile?->instagram_url), 'url' => $profile?->instagram_url],
                        ['icon' => 'fa-solid fa-phone', 'label' => 'Telepon', 'value' => $profile?->phone, 'url' => $profile?->phone ? 'tel:'.$profile->phone : null],
                        ['icon' => 'fa-solid fa-location-dot', 'label' => 'Lokasi', 'value' => $profile?->location, 'url' => null],
                    ])->filter(fn (array $item): bool => filled($item['value']));
                @endphp

                <div class="mt-6 space-y-3">
                    @foreach ($contactItems as $item)
                        <div class="card flex items-center gap-4 p-4">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            <div class="min-w-0">
                                <p class="text-[11px] font-bold uppercase tracking-widest text-slate-400">{{ $item['label'] }}</p>
                                @if ($item['url'])
                                    <a href="{{ $item['url'] }}" @if (str_starts_with($item['url'], 'http')) target="_blank" rel="noopener noreferrer" @endif class="block truncate text-sm font-semibold text-slate-900 transition hover:text-indigo-600 dark:text-white dark:hover:text-indigo-400">{{ $item['value'] }}</a>
                                @else
                                    <p class="truncate text-sm font-semibold text-slate-900 dark:text-white">{{ $item['value'] }}</p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                @php
                    $socials = collect([
                        ['url' => $profile?->github_url, 'icon' => 'fa-brands fa-github', 'label' => 'GitHub'],
                        ['url' => $profile?->instagram_url, 'icon' => 'fa-brands fa-instagram', 'label' => 'Instagram'],
                        ['url' => $profile?->linkedin_url, 'icon' => 'fa-brands fa-linkedin-in', 'label' => 'LinkedIn'],
                    ])->filter(fn (array $item) => filled($item['url']));
                @endphp

                @if ($socials->isNotEmpty())
                    <div class="mt-6">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Media sosial</p>
                        <div class="mt-3 flex gap-2">
                            @foreach ($socials as $social)
                                <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}" class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:border-indigo-400 hover:text-indigo-600 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 focus-visible:ring-offset-2 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-300 dark:hover:border-indigo-500 dark:hover:text-indigo-400 dark:focus-visible:ring-offset-slate-950" title="{{ $social['label'] }}">
                                    <i class="{{ $social['icon'] }}"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="card p-6 sm:p-8">
                <h2 class="text-xl font-extrabold text-slate-900 dark:text-white">Kirim pesan</h2>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Isi form di bawah, pesan akan masuk ke dashboard admin.</p>

                @include('partials.form-errors')

                <form method="POST" action="{{ route('messages.store') }}" class="mt-5 space-y-4">
                    @csrf

                    <div class="grid gap-4 sm:grid-cols-2">
                        <div>
                            <label for="name" class="label">Nama <span class="text-rose-500">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="100" class="input" placeholder="Nama lengkap" autocomplete="name">
                        </div>

                        <div>
                            <label for="email" class="label">Email <span class="text-rose-500">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required maxlength="150" class="input" placeholder="nama@email.com" autocomplete="email">
                        </div>
                    </div>

                    <div>
                        <label for="impression" class="label">Kesan / Hubungan</label>
                        <input type="text" id="impression" name="impression" value="{{ old('impression') }}" maxlength="100" class="input" placeholder="Contoh: Guru pembimbing, teman kelas, pengguna aplikasi">
                    </div>

                    <div>
                        <label for="message" class="label">Pesan <span class="text-rose-500">*</span></label>
                        <textarea id="message" name="message" rows="6" required minlength="10" maxlength="2000" class="input resize-y" placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full">
                        <i class="fa-solid fa-paper-plane"></i>
                        Kirim Pesan
                    </button>

                    <p class="text-center text-[11px] text-slate-400">
                        Form ini dilindungi dari pengiriman berulang (maksimal 5 pesan per menit).
                    </p>
                </form>
            </div>
        </div>
    </section>
@endsection
