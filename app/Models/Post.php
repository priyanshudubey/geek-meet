<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;
    // A Post belongs to a Geek
    public function geek()
    {
        return $this->belongsTo(Geek::class, 'geek_id');
    }
    // A Post can have many Comments
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    // A Post can have many Likes
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
