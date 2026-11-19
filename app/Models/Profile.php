<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'user_id',
    'full_name',
    'headline',
    'photo',
    'class_name',
    'major',
    'bio',
    'career_goal',
    'email',
    'phone',
    'location',
    'github_url',
    'instagram_url',
    'linkedin_url',
])]
class Profile extends Model
{
    use HasFactory;

    /**
     * Profil dimiliki oleh satu akun user (admin).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
