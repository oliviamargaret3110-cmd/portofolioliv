<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['name', 'category', 'percentage', 'icon', 'sort_order'])]
class Skill extends Model
{
    use HasFactory;

    /**
     * Batasi nilai persentase agar selalu 0-100.
     */
    protected function casts(): array
    {
        return [
            'percentage' => 'integer',
        ];
    }

    public function scopeHard(Builder $query): Builder
    {
        return $query->where('category', 'hard');
    }

    public function scopeSoft(Builder $query): Builder
    {
        return $query->where('category', 'soft');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
