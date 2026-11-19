<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'organization',
    'position',
    'type',
    'start_date',
    'end_date',
    'is_current',
    'description',
    'image',
    'sort_order',
])]
class Experience extends Model
{
    use HasFactory;

    public const TYPES = [
        'plk' => 'Praktik Lapangan Kerja (PLK)',
        'kolaborasi' => 'Proyek Kolaborasi',
        'organisasi' => 'Organisasi',
        'lomba' => 'Lomba',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_current' => 'boolean',
        ];
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('start_date')->orderBy('sort_order');
    }
}
