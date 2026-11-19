<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'slug',
    'category',
    'thumbnail',
    'short_description',
    'description',
    'problem',
    'goal',
    'technologies',
    'role',
    'features',
    'documentation',
    'demo_url',
    'github_url',
    'is_featured',
    'sort_order',
])]
class Project extends Model
{
    use HasFactory;

    /**
     * URL publik memakai slug, bukan id.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected function casts(): array
    {
        return [
            'is_featured' => 'boolean',
        ];
    }

    /**
     * Screenshot/dokumentasi tambahan proyek.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }

    /**
     * Feedback/testimoni yang terhubung ke proyek ini.
     */
    public function testimonials(): HasMany
    {
        return $this->hasMany(Testimonial::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->latest();
    }
}
