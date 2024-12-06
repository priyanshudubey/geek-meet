<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
// use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Geek extends Model
{
    use HasFactory;
    // Define a one-to-one relationship with Profile

    protected $fillable = [
        'name',
        'dob',
        'email',
        'password',
    ];
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }
    // A Geek can have many Posts
    public function posts()
    {
        return $this->hasMany(Post::class, 'geek_id');
    }

    // A Geek can have many Comments
    public function comments()
{
    return $this->hasMany(Comment::class, 'user_id');
}

    // A Geek can have many Likes (on posts or comments)
    public function likes()
    {
        return $this->hasMany(Like::class);
    }
}
