<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;
    // A Comment belongs to a Geek
    public function geek()
    {
        return $this->belongsTo(Geek::class);
    }
    // A Comment belongs to a Post
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    // A Comment can have many Likes
    public function likes()
    {
        return $this->morphMany(Like::class, 'likeable');
    }
}
