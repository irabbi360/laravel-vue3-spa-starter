<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
//use Spatie\MediaLibrary\MediaCollections\Models\Media;


class Post extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    protected $fillable = ['title', 'content', 'user_id'];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the category that owns the post.
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class,'category_post');
    }


//    public function media(): \Illuminate\Database\Eloquent\Relations\MorphMany
//    {
//        return $this->morphMany(Media::class, 'model');
//    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('avatars')
        ->useFallbackUrl('/images/placeholder.jpg')
        ->useFallbackPath(public_path('/images/placeholder.jpg'));

        $this->addMediaCollection('images')
            ->useFallbackUrl('/images/placeholder.jpg')
            ->useFallbackPath(public_path('/images/placeholder.jpg'));
    }

}
