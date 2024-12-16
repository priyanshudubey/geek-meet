<div id="postsFeed">
    @foreach ($posts as $post)
        <div class="p-4 border rounded mb-4 bg-white" data-post-id="{{ $post->id }}">
            <div class="flex items-center justify-between">
                <div class="flex items-center space-x-4">
                    @if ($post->user->profile && $post->user->profile->profile_image)
                        <img 
                            src="{{ asset('storage/' . $post->user->profile->profile_image) }}" 
                            class="h-10 w-10 rounded-full object-cover border-2 border-gray-500"
                            alt="Profile Image"
                        >
                    @else
                        <img 
                            src="{{ asset('default-avatar.png') }}" 
                            class="h-10 w-10 rounded-full object-cover border-2 border-gray-500"
                            alt="Default Avatar"
                        >
                    @endif
                    <h4 class="font-bold text-gray-800">{{ $post->user->name ?? 'Unknown User' }}</h4>
                </div>
                <p class="text-gray-600 text-sm">{{ $post->created_at->format('F d, Y h:i A') }}</p>
            </div>
            <p class="text-gray-700">{{ $post->content }}</p>
            @if ($post->picture)
                <img src="/storage/{{ $post->picture }}" class="mt-4 w-32 h-32 rounded" />
            @endif
            <div class="mt-4 flex space-x-4">
                <button class="like-btn text-blue-500" data-id="{{ $post->id }}">
                    {{ $post->is_liked_by_user ? 'Unlike' : 'Like' }} ({{ $post->likes_count ?? 0 }})
                </button>
                <button class="comment-btn text-blue-500" onclick="toggleComments({{ $post->id }})">
                    Comments (<span id="commentCount-{{ $post->id }}">{{ $post->comments->count() }}</span>)
                </button>
            </div>
        </div>
    @endforeach
</div>
