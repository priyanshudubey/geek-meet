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
                .catch(error => console.error('Error:', error));
        });

        // Function to Render a Post
        function renderPost(post) {
    const user = post.user || post.geek; // Adjust based on your relationship
    const postHtml = `
        <div class="p-4 border rounded mb-4 bg-white">
            <div class="flex items-center justify-between">
                <div>
                    <h4 class="font-bold text-gray-800">${user ? user.name : 'Unknown User'}</h4>
                    <p class="text-gray-600 text-sm">${new Date(post.created_at).toLocaleString()}</p>
                </div>
                ${post.user_id === {{ Auth::id() }} ? `
                    <button class="text-blue-500 hover:underline">Edit</button>` : ''}
            </div>
            <p class="mt-2 text-gray-700">${post.content}</p>
            ${post.picture ? `<img src="/storage/${post.picture}" alt="Post Image" class="mt-4 max-w-full rounded">` : ''}
            <div class="mt-4 flex space-x-4">
                <button class="text-blue-500 hover:underline">Like</button>
                <button class="text-blue-500 hover:underline">Comment</button>
            </div>
        </div>
    `;
    document.getElementById('postsFeed').insertAdjacentHTML('afterbegin', postHtml);
}


        // Fetch Existing Posts on Page Load
        document.addEventListener('DOMContentLoaded', () => {
            fetch('/posts') // Fetch posts from the backend
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Render each post
                data.posts.forEach(post => renderPost(post));
            }
        })
        .catch(error => console.error('Error fetching posts:', error));
        });
    </script>

    <!-- Dropdown Script -->
    <script>
        const dropdownButton = document.getElementById('dropdownButton');
        const dropdownMenu = document.getElementById('dropdownMenu');

        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
        });

        window.addEventListener('click', (e) => {
            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
