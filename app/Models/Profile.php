<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    // Define a one-to-one relationship with Geek
    public function geek()
    {
        return $this->belongsTo(Geek::class, 'geek_id');
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
