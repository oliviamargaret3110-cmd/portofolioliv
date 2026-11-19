<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'organizer', 'date', 'description', 'image', 'category', 'sort_order'])]
class Certificate extends Model
{
    use HasFactory;

    /**
     * Kategori yang boleh dipilih pada form admin dan filter publik.
     */
    public const CATEGORIES = [
        'pelatihan' => 'Sertifikat Pelatihan',
        'kompetensi' => 'Sertifikat Kompetensi',
        'kegiatan' => 'Sertifikat Kegiatan',
        'prestasi' => 'Prestasi',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('date')->orderBy('sort_order');
    }
}
