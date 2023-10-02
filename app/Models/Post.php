<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

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
}
