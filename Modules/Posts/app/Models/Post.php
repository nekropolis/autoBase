<?php

namespace Modules\Posts\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\KnowledgeBase\Models\Tag;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->getFirstMediaUrl('post-image') ?: null;
    }

    protected $fillable = ['title', 'slug', 'excerpt', 'body', 'image'];

    protected static function booted()
    {
        static::saving(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
        });
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
