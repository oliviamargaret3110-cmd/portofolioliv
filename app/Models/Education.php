<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'level',
    'school_name',
    'major',
    'start_year',
    'end_year',
    'description',
    'sort_order',
])]
class Education extends Model
{
    use HasFactory;

    /**
     * "Education" dianggap uncountable oleh inflector Laravel,
     * sehingga nama tabel harus ditentukan secara eksplisit.
     */
    protected $table = 'educations';

    /**
     * Urutkan riwayat pendidikan dari yang terbaru.
     */
    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderByDesc('start_year')->orderBy('sort_order');
    }
}
