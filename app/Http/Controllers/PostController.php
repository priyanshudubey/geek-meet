<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'content' => 'required|string|max:255',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $post = new Post();
    $post->user_id = Auth::id(); // Assuming you're using the User model
    $post->content = $request->content;

    if ($request->hasFile('picture')) {
        $post->picture = $request->file('picture')->store('posts', 'public');
    }

    $post->save();

    // Ensure the 'user' relationship is loaded
    $post = $post->load('user'); // Load 'user' or 'geek' based on your setup

    return response()->json([
        'success' => true,
        'post' => $post,
    ]);
}

    public function fetchPosts()
    {
        $posts = Post::with('geek')->latest()->get();

        return response()->json([
            'success' => true,
            'post' => $post,
        ]);
    }

    public function index()
{
    $posts = Post::with('user')->orderBy('created_at', 'desc')->get(); // Load posts with user data
    return response()->json([
        'success' => true,
        'posts' => $posts,
    ]);
}
}
