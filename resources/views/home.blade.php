<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Geek Meet</title>
    @vite('resources/css/app.css')
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-gray-800 text-white py-4">
        <div class="container mx-auto flex justify-between items-center px-4">
            <!-- Navbar Brand -->
            <a class="flex items-center text-[#FF6B6B] text-2xl font-bold hover:scale-105 transition-transform" href="/">
                <i class="fas fa-laptop-code mr-3"></i>
                <span>Geek Meet</span>
            </a>

            <!-- User Dropdown -->
            <div class="relative">
                <button
                    id="dropdownButton"
                    class="flex items-center space-x-2 bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded focus:outline-none"
                >
                    <span>{{ Auth::user()->name }}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-4 w-4">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>
                <!-- Dropdown Menu -->
                <div
                    id="dropdownMenu"
                    class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-10"
                >
                    <a href="/profile" class="block px-4 py-2 text-gray-800 hover:bg-gray-100">Profile</a>
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container mx-auto mt-10 px-4">
        <h2 class="text-sky-500 text-2xl font-semibold mb-4">Hello, {{ Auth::user()->name }}!</h2>
        <p class="text-gray-700 text-lg mb-6">Explore, connect, and share your passion with fellow tech enthusiasts.</p>

        <!-- Create Post Section -->
        <div class="mb-6 p-4 bg-white rounded shadow">
            <textarea id="postContent" rows="4" placeholder="What's on your mind?" class="w-full p-2 border rounded"></textarea>
            <input type="file" id="postPicture" class="mt-2">
            <button id="postButton" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">Post</button>
        </div>

        <!-- Posts Feed -->
        <div id="postsFeed"></div>
    </main>

    <!-- JavaScript for Posts -->
    <script>
        // Load posts from the server
        function loadPosts() {
            fetch('/posts')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        data.posts.forEach(post => renderPost(post));
                    }
                })
                .catch(error => console.error('Error fetching posts:', error));
        }

        // Render a single post
        function renderPost(post) {
    const user = post.user || post.geek; // Adjust based on your relationship
    const postHtml = `
        <div class="p-4 border rounded mb-4 bg-white" data-post-id="${post.id}">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-gray-800">${user ? user.name : 'Unknown User'}</h4>
                    <p class="text-gray-600 text-sm">${new Date(post.created_at).toLocaleString()}</p>
                </div>
                ${
                    post.user_id === {{ Auth::id() }} ? `
                    <div class="relative">
                        <button id="settingsButton-${post.id}" class="text-gray-500 hover:text-gray-800">
                            <i class="fas fa-cog"></i>
                        </button>
                        <div id="settingsDropdown-${post.id}" class="hidden absolute right-0 mt-2 w-32 bg-white border border-gray-200 rounded shadow-lg z-10">
                            <button class="block px-4 py-2 text-left text-gray-800 hover:bg-gray-100 edit-post-btn" data-id="${post.id}">Edit</button>
                            <button class="block px-4 py-2 text-left text-red-600 hover:bg-gray-100 delete-post-btn" data-id="${post.id}">Delete</button>
                        </div>
                    </div>
                    ` : ''
                }
            </div>
            <!-- Editable Post Content -->
            <div class="mt-2">
                <p class="text-gray-700 post-content">${post.content}</p>
                <textarea class="hidden w-full p-2 border rounded edit-content">${post.content}</textarea>
            </div>
            <!-- Save and Cancel Buttons -->
            <div class="hidden mt-2 flex space-x-2 edit-actions">
                <button class="bg-blue-500 text-white py-1 px-3 rounded save-edit-btn" data-id="${post.id}">Save</button>
                <button class="bg-gray-500 text-white py-1 px-3 rounded cancel-edit-btn" data-id="${post.id}">Cancel</button>
            </div>
            ${
                post.picture
                    ? `<img src="/storage/${post.picture}" alt="Post Image" class="mt-4 w-32 h-32 rounded">`
                    : ''
            }
            <div class="mt-4 flex space-x-4">
                <button class="text-blue-500 hover:underline">Like</button>
                <button class="text-blue-500 hover:underline">Comment</button>
            </div>
        </div>
    `;
    document.getElementById('postsFeed').insertAdjacentHTML('afterbegin', postHtml);

    // Add dropdown event listener
    const settingsButton = document.getElementById(`settingsButton-${post.id}`);
    const settingsDropdown = document.getElementById(`settingsDropdown-${post.id}`);
    if (settingsButton && settingsDropdown) {
        settingsButton.addEventListener('click', () => {
            settingsDropdown.classList.toggle('hidden');
        });
    }

    // Add Edit Button Functionality
    const editButton = document.querySelector(`[data-id="${post.id}"].edit-post-btn`);
    const deleteButton = document.querySelector(`[data-id="${post.id}"].delete-post-btn`);
    const postElement = document.querySelector(`[data-post-id="${post.id}"]`);
    const postContent = postElement.querySelector('.post-content');
    const editContent = postElement.querySelector('.edit-content');
    const editActions = postElement.querySelector('.edit-actions');

    if (editButton) {
        editButton.addEventListener('click', () => {
            postContent.classList.add('hidden');
            editContent.classList.remove('hidden');
            editActions.classList.remove('hidden');
        });
    }

    // Add Cancel Button Functionality
    const cancelButton = postElement.querySelector('.cancel-edit-btn');
    if (cancelButton) {
        cancelButton.addEventListener('click', () => {
            postContent.classList.remove('hidden');
            editContent.classList.add('hidden');
            editActions.classList.add('hidden');
        });
    }

    // Add Save Button Functionality
    const saveButton = postElement.querySelector('.save-edit-btn');
    if (saveButton) {
        saveButton.addEventListener('click', () => {
            const newContent = editContent.value;
            fetch(`/posts/${post.id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ content: newContent }),
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to update post');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        postContent.textContent = newContent;
                        postContent.classList.remove('hidden');
                        editContent.classList.add('hidden');
                        editActions.classList.add('hidden');
                    }
                })
                .catch(error => console.error('Error updating post:', error));
        });
    }
}

        // Post a new post
        document.getElementById('postButton').addEventListener('click', () => {
            const content = document.getElementById('postContent').value;
            const picture = document.getElementById('postPicture').files[0];
            const formData = new FormData();

            formData.append('content', content);
            if (picture) {
                formData.append('picture', picture);
            }

            fetch('/posts', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Render the new post
                        renderPost(data.post);
                        document.getElementById('postContent').value = '';
                        document.getElementById('postPicture').value = '';
                    }
                })
                .catch(error => console.error('Error posting:', error));
        });

        // Edit and Delete Event Handlers
        document.addEventListener('click', (event) => {
            if (event.target.classList.contains('edit-post-btn')) {
                const postId = event.target.getAttribute('data-id');
                editPost(postId);
            } else if (event.target.classList.contains('delete-post-btn')) {
                const postId = event.target.getAttribute('data-id');
                deletePost(postId);
            }
        });

//         function editPost(postId) {
//     // Find the post content
//     const postElement = document.querySelector(`[data-post-id="${postId}"]`);
//     const currentContent = postElement ? postElement.querySelector('.post-content').textContent : '';

//     // Prompt the user with the current content
//     const newContent = prompt('Edit your post:', currentContent);

//     if (newContent !== null) { // Allow the user to cancel editing
//         fetch(`/posts/${postId}`, {
//             method: 'PUT',
//             headers: {
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
//                 'Content-Type': 'application/json',
//             },
//             body: JSON.stringify({ content: newContent }),
//         })
//             .then(response => {
//                 if (!response.ok) {
//                     throw new Error('Failed to update post');
//                 }
//                 return response.json();
//             })
//             .then(data => {
//                 if (data.success) {
//                     alert('Post updated successfully!');
//                     // Update the post content on the page without reloading
//                     if (postElement) {
//                         postElement.querySelector('.post-content').textContent = newContent;
//                     }
//                 }
//             })
//             .catch(error => console.error('Error updating post:', error));
//     }
// }
function editPost(postId) {
    const postElement = document.querySelector(`[data-post-id="${postId}"]`);
    const postContent = postElement.querySelector('.post-content');
    const editContent = postElement.querySelector('.edit-content');
    const editActions = postElement.querySelector('.edit-actions');

    // Show the edit textarea and buttons
    postContent.classList.add('hidden');
    editContent.classList.remove('hidden');
    editActions.classList.remove('hidden');
}

                function deletePost(postId) {
                    if (confirm('Are you sure you want to delete this post?')) {
                        fetch(`/posts/${postId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            },
                        })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Failed to delete post');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert('Post deleted successfully!');
                            document.getElementById('postsFeed').innerHTML = ''; // Clear posts feed
                            loadPosts(); // Reload posts
                        }
                    })
                    .catch(error => console.error('Error deleting post:', error));
                    }
                }
        // Load posts on page load
        document.addEventListener('DOMContentLoaded', loadPosts);
    </script>
</body>
</html>
