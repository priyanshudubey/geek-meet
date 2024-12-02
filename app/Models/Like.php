<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Like extends Model
{
    use HasFactory;
    // A Like belongs to a Geek
    public function geek()
    {
        return $this->belongsTo(Geek::class);
    }
    // A Like can be associated with either a Post or a Comment
    public function likeable()
    {
        return $this->morphTo();
    }
}
