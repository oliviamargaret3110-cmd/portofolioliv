<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['project_id', 'name', 'position', 'category', 'content', 'photo', 'sort_order'])]
class Testimonial extends Model
{
    use HasFactory;

    public const CATEGORIES = [
        'guru' => 'Guru Pembimbing',
        'teman' => 'Teman',
        'pengguna' => 'Pengguna',
        'plk' => 'Tempat PLK',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->latest();
    }
}
