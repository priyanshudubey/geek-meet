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

            <!-- Notifications -->
            <div class="relative mr-4">
                <button
                    id="notificationButton"
                    class="relative bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded focus:outline-none"
                >
                    <i class="fas fa-bell"><span class="text-sm mx-2">Notification</span></i>
                    <span
                        id="notificationCount"
                        class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center"
                    >0</span>
                </button>
                <!-- Notification Dropdown -->
                <div
                    id="notificationDropdown"
                    class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow-lg z-10"
                >
                    <div id="notificationList">
                        <p class="px-4 py-2 text-gray-600">No new notifications</p>
                    </div>
                    <button
                        id="markAsReadButton"
                        class="block w-full text-center bg-red-500 text-white py-2 hover:bg-red-600"
                    >
                        Mark All as Read
                    </button>
                </div>
            </div>

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

    <!-- JavaScript -->
    <script>
        // Notifications functionality
        document.getElementById('notificationButton').addEventListener('click', () => {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('hidden');
        });

        function loadNotifications() {
            fetch('/notifications')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notificationCount = data.notifications.length;
                        document.getElementById('notificationCount').textContent = notificationCount;

                        const notificationList = document.getElementById('notificationList');
                        notificationList.innerHTML = '';

                        if (notificationCount > 0) {
                            data.notifications.forEach(notification => {
                                const notificationHtml = `
                                    <div class="mb-2 p-2 border-b">
                                        <p class="text-gray-700">${notification.data.message}</p>
                                        <small class="text-gray-500">${new Date(notification.created_at).toLocaleString()}</small>
                                    </div>
                                `;
                                notificationList.insertAdjacentHTML('beforeend', notificationHtml);
                            });
                        } else {
                            notificationList.innerHTML = '<p class="text-gray-500 text-sm">No new notifications</p>';
                        }
                    }
                })
                .catch(error => console.error('Error fetching notifications:', error));
        }

        document.getElementById('markAsReadButton').addEventListener('click', () => {
            fetch('/notifications/mark-as-read', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to mark notifications as read');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        document.getElementById('notificationList').innerHTML = '<p class="text-gray-500 text-sm">No new notifications</p>';
                        document.getElementById('notificationCount').textContent = 0;
                    }
                })
                .catch(error => console.error('Error marking notifications as read:', error));
        });

        document.addEventListener('DOMContentLoaded', loadNotifications);

        // Dropdown menu for user
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', event => {
            event.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', event => {
            if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });

        // Load posts
        function loadPosts() {
            fetch('/posts')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('postsFeed').innerHTML = ''; // Clear existing posts
                        data.posts.forEach(post => renderPost(post));
                    }
                })
                .catch(error => console.error('Error fetching posts:', error));
        }

        function renderPost(post) {
            const postHtml = `
                <div class="p-4 border rounded mb-4 bg-white" data-post-id="${post.id}">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-gray-800">${post.user ? post.user.name : 'Unknown User'}</h4>
                        <p class="text-gray-600 text-sm">${new Date(post.created_at).toLocaleString()}</p>
                    </div>
                    <p class="text-gray-700">${post.content}</p>
                    ${post.picture ? `<img src="/storage/${post.picture}" class="mt-4 w-32 h-32 rounded" />` : ''}
                    <div class="mt-4 flex space-x-4">
                        <button class="like-btn text-blue-500" data-id="${post.id}">
                            ${post.is_liked_by_user ? 'Unlike' : 'Like'} (${post.likes_count || 0})
                        </button>
                        <button class="comment-btn text-blue-500" data-id="${post.id}">
                            Comments (<span id="commentCount-${post.id}">${post.comments ? post.comments.length : 0}</span>)
                        </button>
                    </div>
                    <div id="commentsSection-${post.id}" class="hidden mt-4 bg-gray-50 p-4 rounded shadow">
                        <div id="commentsList-${post.id}">
                            ${post.comments
                                ? post.comments
                                      .map(
                                          comment => `
                                    <div class="mb-2 p-2 border rounded">
                                        <strong>${comment.user ? comment.user.name : 'Unknown User'}</strong>
                                        <p>${comment.content}</p>
                                    </div>
                                `
                                      )
                                      .join('')
                                : ''}
                        </div>
                        <textarea id="newComment-${post.id}" class="w-full p-2 border rounded mb-2" placeholder="Write a comment..."></textarea>
                        <button class="bg-blue-500 text-white py-1 px-4 rounded add-comment-btn" data-id="${post.id}">
                            Post Comment
                        </button>
                    </div>
                </div>
            `;
            document.getElementById('postsFeed').insertAdjacentHTML('beforeend', postHtml);

            document.querySelector(`.like-btn[data-id="${post.id}"]`).addEventListener('click', () => {
                const likeButton = event.target;
                fetch(`/posts/${post.id}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    },
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            likeButton.textContent = `${data.is_liked_by_user ? 'Unlike' : 'Like'} (${data.likes_count})`;
                        }
                    })
                    .catch(error => console.error('Error toggling like:', error));
            });

            document.querySelector(`.add-comment-btn[data-id="${post.id}"]`).addEventListener('click', () => {
                const content = document.getElementById(`newComment-${post.id}`).value;
                fetch(`/posts/${post.id}/comments`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({ content }),
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const commentHtml = `
                                <div class="mb-2 p-2 border rounded">
                                    <strong>${data.comment.user.name}</strong>
                                    <p>${data.comment.content}</p>
                                </div>
                            `;
                            document.getElementById(`commentsList-${post.id}`).insertAdjacentHTML('beforeend', commentHtml);
                            document.getElementById(`newComment-${post.id}`).value = '';
                            const commentCount = document.getElementById(`commentCount-${post.id}`);
                            commentCount.textContent = parseInt(commentCount.textContent) + 1;
                        }
                    })
                    .catch(error => console.error('Error adding comment:', error));
            });

            document.querySelector(`.comment-btn[data-id="${post.id}"]`).addEventListener('click', () => {
                document.getElementById(`commentsSection-${post.id}`).classList.toggle('hidden');
            });
        }

        document.getElementById('postButton').addEventListener('click', () => {
            const content = document.getElementById('postContent').value;
            const picture = document.getElementById('postPicture').files[0];
            const formData = new FormData();
            formData.append('content', content);
            if (picture) formData.append('picture', picture);

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
                        renderPost(data.post);
                        document.getElementById('postContent').value = '';
                        document.getElementById('postPicture').value = '';
                    }
                })
                .catch(error => console.error('Error posting:', error));
        });

        document.addEventListener('DOMContentLoaded', loadPosts);
    </script>
</body>
</html>
