<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PostController extends Controller
{
    use AuthorizesRequests;
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'nullable|string|max:255',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gif_url' => 'nullable|string',
        ]);
        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;
        $post->gif_url = $request->gif_url;
        if ($request->hasFile('picture')) {
            $post->picture = $request->file('picture')->store('posts', 'public');
        }
        $post->save();
        return response()->json([
            'success' => true,
            'post' => $post->load('user'), 
        ]);
    }


    public function fetchPosts()
    {
        $posts = Post::with(['user', 'likes', 'comments.user', 'user.profile'])->latest()->get()->map(function ($post) {
            $post->likes_count = $post->likes->count();
            $post->is_liked_by_user = $post->likes->where('user_id', auth()->id())->isNotEmpty();
            return $post;
        });

        return response()->json([
            'success' => true,
            'posts' => $posts,
        ]);
    }

    public function update(Request $request, Post $post)
    {
        if ($post->user_id !== auth()->id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }
        $request->validate([
            'content' => 'required|string|max:500',
        ]);
        $post->content = $request->content;
        $post->save();
        return response()->json(['success' => true, 'post' => $post]);
    }

    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();
        return response()->json(['success' => true]);
    }

    public function index()
    {
        $posts = Post::with(['user', 'comments'])->get();
        dd($posts); 
        return view('home', compact('posts'));
    }
}
