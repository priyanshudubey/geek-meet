@extends('layouts.app')

@section('title', $user->name . "'s Profile")

@section('content')
<div class="container mx-auto mt-6">
    <!-- Profile Section -->
    <div class="flex items-center space-x-4 p-4 bg-white shadow rounded">
        @if($user->profile && $user->profile->profile_image)
            <img src="{{ asset('storage/' . $user->profile->profile_image) }}" alt="{{ $user->name }}'s Profile Picture" class="h-16 w-16 rounded-full object-cover">
        @else
            <div class="h-16 w-16 flex items-center justify-center rounded-full bg-gray-500 text-white font-bold text-lg">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
            
        @endif
        <div>
            <h2 class="text-xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-600">{{ $user->profile->bio ?? 'No bio available.' }}</p>
            <p class="text-gray-600">{{ $user->profile->location ?? 'Location not provided.' }}</p>
        </div>
    </div>

    <!-- User's Posts Section -->
    <div class="mt-6">
        <h3 class="text-2xl font-semibold mb-4">{{ $user->name }}'s Posts</h3>
        <div id="postsFeed">
            @forelse ($posts as $post)
                <div class="p-4 border rounded mb-4 bg-white" data-post-id="{{ $post->id }}">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-4">
                            @if ($post->user->profile && $post->user->profile->profile_image)
                                <img src="{{ asset('storage/' . $post->user->profile->profile_image) }}" class="h-10 w-10 rounded-full object-cover border-2 border-gray-500" alt="{{ $post->user->name }}'s Profile Picture">
                            @else
                                <div class="h-10 w-10 flex items-center justify-center rounded-full bg-gray-500 text-white font-bold text-lg">
                                    {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                </div>
                            @endif
                            <h4 class="font-bold text-gray-800">{{ $post->user->name }}</h4>
                        </div>
                        <p class="text-gray-600 text-sm">{{ $post->created_at->format('F d, Y h:i A') }}</p>
                    </div>
                    <p class="text-gray-700">{{ $post->content }}</p>
                    @if ($post->gif_url)
                        <img src="{{ $post->gif_url }}" alt="GIF" class="mt-4 w-32 h-32 rounded">
                    @endif
                    @if ($post->picture)
                        <img src="{{ asset('storage/' . $post->picture) }}" class="mt-4 w-32 h-32 rounded" alt="Post Image">
                    @endif
                    <div class="mt-4 flex space-x-4">
                        <!-- Like Button -->
                        <button class="like-btn text-blue-500" data-id="{{ $post->id }}">
                            {{ $post->is_liked_by_user ? 'Unlike' : 'Like' }} ({{ $post->likes->count() }})
                        </button>

                        <!-- Comment Button -->
                        <button class="comment-btn text-blue-500" onclick="toggleComments({{ $post->id }})">
                            Comments (<span id="commentCount-{{ $post->id }}">{{ $post->comments->count() }}</span>)
                        </button>
                    </div>
                    <!-- Comments Section -->
                    <div id="commentsSection-{{ $post->id }}" class="hidden mt-4 bg-gray-50 p-4 rounded shadow">
                        <div id="commentsList-{{ $post->id }}">
                            @foreach ($post->comments as $comment)
                                <div class="mb-2 p-2 border rounded">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <p>{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                        <textarea id="newComment-{{ $post->id }}" class="w-full p-2 border rounded mb-2" placeholder="Write a comment..."></textarea>
                        <button class="bg-blue-500 text-white py-1 px-4 rounded add-comment-btn" data-id="{{ $post->id }}">
                            Post Comment
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-gray-500">This user has not posted anything yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
