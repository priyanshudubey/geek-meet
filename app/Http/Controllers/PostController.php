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
        'content' => 'required|string|max:255',
        'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $post = new Post();
    $post->user_id = Auth::id();
    $post->content = $request->content;

    if ($request->hasFile('picture')) {
        // Store the image in the "posts" directory in the public disk
        $post->picture = $request->file('picture')->store('posts', 'public');
    }

    $post->save();

    return response()->json([
        'success' => true,
        'post' => $post->load('user'), // Ensure the user relationship is included
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

    public function update(Request $request, Post $post)
{
    $request->validate([
        'content' => 'required|string|max:255',
    ]);

    $post->content = $request->content;
    $post->save();

    return response()->json(['success' => true, 'post' => $post]);
}

public function destroy(Post $post)
{
    // Authorize the user to delete the post
    \Log::info('Attempting to delete post', [
        'post_id' => $post->id,
        'user_id' => Auth::id(),
        'post_owner_id' => $post->user_id,
    ]);

    $this->authorize('delete', $post);

    // Delete the post
    $post->delete();

    // Return a success response
    return response()->json(['success' => true]);
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
