<?php

use App\Models\Setting;
use Illuminate\Support\Carbon;

/**
 * Ambil satu nilai pengaturan website dari tabel settings.
 * Hasil di-cache per request agar tidak query berulang.
 */
function setting(string $key, ?string $default = null): ?string
{
    static $settings = null;

    if ($settings === null) {
        $settings = Setting::query()->pluck('value', 'key')->all();
    }

    return $settings[$key] ?? $default;
}

/**
 * Ubah path gambar di database menjadi URL yang bisa diakses browser.
 * Path "seed/..." adalah placeholder bawaan, path lain adalah hasil upload.
 */
function media_url(?string $path, string $fallback = 'seed/placeholder.svg'): string
{
    $path = $path ?: $fallback;

    if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
        return $path;
    }

    return asset('storage/'.ltrim($path, '/'));
}

/**
 * Bersihkan teks internal agar tidak tampil ke pengunjung.
 * Menghapus penanda "(Placeholder ...)" dan instruksi "Ganti ... melalui Dashboard Admin".
 */
function public_text(?string $text): string
{
    if (blank($text)) {
        return '';
    }

    $text = preg_replace('/\s*\(\s*placeholder[^)]*\)/iu', '', $text) ?? $text;
    $text = preg_replace('/\s*(?:silakan\s+)?ganti\b[^.]*?dashboard admin\b[^.]*\.?/iu', '', $text) ?? $text;
    $text = preg_replace('/\s{2,}/u', ' ', $text) ?? $text;

    return trim($text);
}

/**
 * Deteksi teks contoh/placeholder bawaan seeder.
 * Dipakai agar data contoh tidak ikut tampil di CV Digital.
 */
function has_placeholder(?string $text): bool
{
    if (blank($text)) {
        return false;
    }

    return (bool) preg_match('/\(\s*placeholder|ganti\b[^.]*?dashboard admin/iu', $text);
}

/**
 * Ambil username Instagram dari URL profil, contoh: @olvymrgt.
 */
function instagram_username(?string $url): ?string
{
    if (blank($url)) {
        return null;
    }

    $path = trim((string) parse_url($url, PHP_URL_PATH), '/');

    return $path !== '' ? '@'.ltrim($path, '@') : null;
}

/**
 * URL foto profil utama website.
 * Memakai foto hasil upload admin jika ada, dan foto bawaan public/image/profil.jpeg
 * jika profil masih memakai placeholder seed.
 */
function profile_photo_url(?string $path): string
{
    if (filled($path) && ! str_starts_with($path, 'seed/')) {
        return media_url($path);
    }

    return asset('image/profil.jpeg');
}

/**
 * Format tanggal ke bahasa Indonesia, contoh: 12 November 2026.
 */
function format_date_id(mixed $date, string $format = 'd F Y'): string
{
    if (blank($date)) {
        return '-';
    }

    return Carbon::parse($date)->locale('id')->translatedFormat($format);
}

/**
 * Format periode pengalaman, contoh: Juli 2024 - Oktober 2024.
 * Format tanggal bisa diubah, misalnya "j F Y" untuk menampilkan hari.
 */
function period_id(mixed $start, mixed $end = null, bool $isCurrent = false, string $format = 'F Y'): string
{
    if (blank($start)) {
        return '-';
    }

    $startText = Carbon::parse($start)->locale('id')->translatedFormat($format);

    if ($isCurrent) {
        return $startText.' - Sekarang';
    }

    if (blank($end)) {
        return $startText;
    }

    $endText = Carbon::parse($end)->locale('id')->translatedFormat($format);

    return $startText.' - '.$endText;
}

/**
 * Inisial nama untuk avatar.
 */
function initials(?string $name): string
{
    $words = preg_split('/\s+/', trim((string) $name)) ?: [];

    return collect($words)
        ->filter()
        ->take(2)
        ->map(fn (string $word) => strtoupper(mb_substr($word, 0, 1)))
        ->implode('') ?: '?';
}
