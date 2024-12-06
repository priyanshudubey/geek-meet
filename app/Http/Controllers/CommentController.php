<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Notification;
use App\Notifications\CommentNotification;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
{
    $validated = $request->validate([
        'content' => 'required|string|max:255',
    ]);

    $comment = $post->comments()->create([
        'user_id' => auth()->id(),
        'content' => $validated['content'],
    ]);

    // Notify the post owner
    if ($post->user_id !== auth()->id()) {
        $post->user->notify(new CommentNotification(auth()->user()->name));
    }

    return response()->json([
        'success' => true,
        'comment' => $comment->load('user'), // Ensure the user relationship is loaded
        'comments_count' => $post->comments()->count(), // Update comments count dynamically
    ]);
}
}
