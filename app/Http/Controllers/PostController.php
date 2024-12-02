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
            'content' => 'required|string|max:5000',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;

        if ($request->hasFile('picture')) {
            $post->picture = $request->file('picture')->store('posts', 'public');
        }

        $post->save();

        return response()->json([
            'success' => true,
            'post' => $post->load('geek'),
        ]);
    }

    public function fetchPosts()
    {
        $posts = Post::with('geek')->latest()->get();

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ]);
    }
}
