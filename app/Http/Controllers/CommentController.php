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

    if ($post->user_id !== auth()->id()) {
        Log::info('Sending comment notification to user:', ['user_id' => $post->user_id]);
        $post->user->notify(new CommentNotification(auth()->user(), $comment));
    }

    return response()->json([
        'success' => true,
        'comment' => $comment->load('user'),
    ]);
}

}
