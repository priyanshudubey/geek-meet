<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Geek extends Model
{
    use HasFactory;
    // Define a one-to-one relationship with Profile
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    // A Geek can have many Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // A Geek can have many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    // A Geek can have many Likes (on posts or comments)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
