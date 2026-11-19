<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Pembantu penyimpanan gambar ke disk "public".
 * File placeholder bawaan (folder seed/) tidak pernah dihapus.
 */
class ImageStorage
{
    public static function store(?UploadedFile $file, string $folder): ?string
    {
        return $file?->store($folder, 'public');
    }

    public static function replace(?UploadedFile $file, string $folder, ?string $oldPath = null): ?string
    {
        if (! $file) {
            return $oldPath;
        }

        self::delete($oldPath);

        return self::store($file, $folder);
    }

    public static function delete(?string $path): void
    {
        if (blank($path) || str_starts_with($path, 'seed/')) {
            return;
        }

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
