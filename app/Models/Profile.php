<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Allow mass assignment of user_id
        'bio',
        'location',
        'profile_image',
    ];

    // Define a one-to-one relationship with Geek
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    // A Profile can have many Posts
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    // A Profile can have many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
