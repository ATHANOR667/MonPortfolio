<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'full_name',
        'title',
        'bio',
        'photo',
        'cv_path',
        'email',
        'phone',
        'location',
        'website',
        'linkedin',
        'github',
        'twitter'
    ];


    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function educations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Education::class);
    }


    public function experiences(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Experience::class);
    }
}
