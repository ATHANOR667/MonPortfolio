<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'client',
        'date',
        'url',
        'featured_image',
        'video_url',
        'is_published',
        'views_count',
        'user_id',
    ];


    protected $casts = [
        'date' => 'date',
        'is_published' => 'boolean',
        'views_count' => 'integer',
    ];



    public function getRouteKeyName(): string
    {
        return 'slug';
    }


    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_project', 'project_id', 'category_id');
    }


    public function images(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('order');
    }


    public function comments(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Comment::class);
    }


    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }


    public function incrementViewCount(): void
    {
        $this->increment('views_count');
    }
}
