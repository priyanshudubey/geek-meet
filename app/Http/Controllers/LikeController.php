<?php

namespace App\Http\Controllers;
use App\Models\Post;

use Illuminate\Http\Request;
use App\Models\Notification;
use App\Notifications\LikeNotification;
use Illuminate\Support\Facades\Log;

class LikeController extends Controller
{
    public function toggleLike(Request $request, Post $post)
{
    $user = auth()->user();

    // Check if the user already liked the post
    $existingLike = $post->likes()->where('user_id', $user->id)->first();

    if ($existingLike) {
        // Unlike the post
        $existingLike->delete();

        return response()->json([
            'success' => true,
            'message' => 'Like',
            'is_liked_by_user' => false,
            'likes_count' => $post->likes()->count(),
        ]);
    }

    // Like the post
    $post->likes()->create(['user_id' => $user->id]);

    // Notify the post owner
    if ($post->user_id !== $user->id) {
        Log::info('Sending like notification to user:', ['user_id' => $post->user_id]);
        $post->user->notify(new LikeNotification($user, $post));
    }

    return response()->json([
        'success' => true,
        'message' => 'Unlike',
        'is_liked_by_user' => true,
        'likes_count' => $post->likes()->count(),
    ]);
}


}