console.log('Home JS Loaded');
// Load posts on page load
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Content Loaded');
    loadPosts();

    const postButton = document.getElementById('postButton');
    if (postButton) {
        console.log('Post button found');
        postButton.addEventListener('click', handleCreatePost);
    } else {
        console.error('Post button not found');
    }
});

function loadNotifications() {
    fetch("/notifications")
        .then((response) => response.json())
        .then((data) => {
            console.log("Notifications fetched:", data); // Debugging
            const notificationCount = data.notifications.length;
            document.getElementById("notificationCount").textContent = notificationCount;

            const notificationList = document.getElementById("notificationList");
            notificationList.innerHTML = "";

            if (notificationCount > 0) {
                data.notifications.forEach((notification) => {
                    const notificationHtml = `
                        <div class="mb-2 p-2 border-b">
                            <p class="text-gray-700">${notification.data.message}</p>
                            <small class="text-gray-500">${new Date(notification.created_at).toLocaleString()}</small>
                        </div>
                    `;
                    notificationList.insertAdjacentHTML("beforeend", notificationHtml);
                });
            } else {
                notificationList.innerHTML = '<p class="text-gray-500 text-sm">No new notifications</p>';
            }
        })
        .catch((error) => console.error("Error fetching notifications:", error));
}

document.addEventListener("DOMContentLoaded", loadNotifications);


function handleCreatePost() {
    console.log('Post button clicked');

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
            console.log('Post response:', data);
            if (data.success) {
                alert('Post created successfully!');
                loadPosts();
                document.getElementById('postContent').value = '';
                document.getElementById('postPicture').value = '';
            } else {
                alert('Failed to create post');
            }
        })
        .catch(error => console.error('Error posting:', error));
}

function loadPosts() {
    console.log('Loading posts...');

    fetch('/posts', {
        method: 'GET',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Loaded posts:', data);
        if (data.success) {
            const postsFeed = document.getElementById('postsFeed');
            postsFeed.innerHTML = ''; // Clear old posts
            data.posts.forEach(post => renderPost(post));
        } else {
            console.error('Failed to load posts:', data);
        }
    })
    .catch(error => console.error('Error loading posts:', error));
}



function renderPost(post) {
    console.log("Rendering post:", post); // Debugging the post object

    const loggedInUserId = parseInt(document.querySelector('meta[name="user-id"]').getAttribute('content'));

    const postHtml = `
        <div class="p-4 border rounded mb-4 bg-white" data-post-id="${post.id}">
            <div class="flex justify-between">
                <h4 class="font-bold text-gray-800">${post.user ? post.user.name : 'Unknown User'}</h4>
                <p class="text-gray-600 text-sm">${new Date(post.created_at).toLocaleString()}</p>
                ${
                    post.user_id === loggedInUserId
                        ? `
                        <button class="edit-post-btn text-blue-600" data-id="${post.id}">Edit</button>
                        <button class="delete-post-btn text-red-600" data-id="${post.id}">Delete</button>
                        `
                        : ''
                }
            </div>
            <p class="text-gray-700">${post.content ? post.content : 'No content available'}</p>
            ${
                post.picture
                    ? `<img src="/storage/${post.picture}" class="mt-4 w-32 h-32 rounded" />`
                    : ''
            }
            <div class="mt-4 flex space-x-4">
                <button class="like-btn text-blue-500" data-id="${post.id}">
                    ${post.is_liked_by_user ? 'Unlike' : 'Like'} (${post.likes_count || 0})
                </button>
                <button class="comment-btn text-blue-500" onclick="toggleComments(${post.id})">
                    Comments (<span id="commentCount-${post.id}">${post.comments?.length || 0}</span>)
                </button>
            </div>
        </div>
    `;

    const postsFeed = document.getElementById('postsFeed');
    if (postsFeed) {
        postsFeed.insertAdjacentHTML('beforeend', postHtml);
    }

    // Attach event listeners for Edit and Delete buttons
    const editButton = document.querySelector(`.edit-post-btn[data-id="${post.id}"]`);
    const deleteButton = document.querySelector(`.delete-post-btn[data-id="${post.id}"]`);

    if (editButton) {
        editButton.addEventListener('click', () => {
            console.log(`Edit button clicked for post: ${post.id}`);
            editPost(post.id);
        });
    }

    if (deleteButton) {
        deleteButton.addEventListener('click', () => {
            console.log(`Delete button clicked for post: ${post.id}`);
            deletePost(post.id);
        });
    }
}


function addCommentListeners() {
    const commentButtons = document.querySelectorAll('.add-comment-btn');
    commentButtons.forEach(button => {
        button.addEventListener('click', () => {
            console.log('Post Comment button clicked');
            const postId = button.dataset.id;
            const content = document.getElementById(`newComment-${postId}`).value.trim();

            if (!content) {
                alert('Comment cannot be empty');
                return;
            }

            fetch(`/posts/${postId}/comments`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ content }),
            })
                .then(response => response.json())
                .then(data => {
                    console.log('Comment response:', data);
                    if (data.success) {
                        const commentHtml = `
                            <div class="mb-2 p-2 border rounded">
                                <strong>${data.comment.user.name}</strong>
                                <p>${data.comment.content}</p>
                            </div>
                        `;
                        const commentsList = document.getElementById(`commentsList-${postId}`);
                        commentsList.insertAdjacentHTML('beforeend', commentHtml);
                        document.getElementById(`newComment-${postId}`).value = '';
                        const commentCount = document.getElementById(`commentCount-${postId}`);
                        commentCount.textContent = parseInt(commentCount.textContent) + 1;
                    }
                })
                .catch(error => console.error('Error adding comment:', error));
        });
    });
}

function addLikeListeners() {
    const likeButtons = document.querySelectorAll('.like-btn');
    likeButtons.forEach(button => {
        button.addEventListener('click', () => {
            const postId = button.dataset.id;
            toggleLike(postId);
        });
    });
}

function toggleComments(postId) {
    console.log(`Comment button clicked for post: ${postId}`);
    const commentsSection = document.getElementById(`commentsSection-${postId}`);
    if (commentsSection) {
        commentsSection.classList.toggle('hidden');
    } else {
        console.error(`Comments section not found for post: ${postId}`);
    }
}

window.toggleComments = toggleComments;

function toggleLike(postId) {
    console.log(`Like button clicked for post: ${postId}`);
    const likeButton = document.querySelector(`.like-btn[data-id="${postId}"]`);
    if (!likeButton) {
        console.error(`Like button not found for post: ${postId}`);
        return;
    }

    fetch(`/posts/${postId}/like`, {
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
}


document.addEventListener("DOMContentLoaded", () => {
    console.log("DOM Loaded");

    // Toggle dropdown visibility
    const notificationButton = document.getElementById("notificationButton");
    if (notificationButton) {
        notificationButton.addEventListener("click", (event) => {
            console.log("Notification button clicked");
            event.stopPropagation();
            const dropdown = document.getElementById("notificationDropdown");
            dropdown.classList.toggle("hidden");
        });
    }

    // Close dropdown if clicking outside
    document.addEventListener("click", (event) => {
        const dropdown = document.getElementById("notificationDropdown");
        const notificationButton = document.getElementById("notificationButton");

        if (
            dropdown &&
            !dropdown.contains(event.target) &&
            !notificationButton.contains(event.target)
        ) {
            dropdown.classList.add("hidden");
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const markAsReadButton = document.getElementById("markAsReadButton");

    if (markAsReadButton) {
        markAsReadButton.addEventListener("click", () => {
            console.log("Mark All as Read button clicked"); // Debugging
            fetch("/notifications/mark-as-read", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                    "Content-Type": "application/json",
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error(`Failed to mark notifications as read: ${response.statusText}`);
                    }
                    return response.json();
                })
                .then((data) => {
                    console.log("Mark as Read response:", data); // Debugging
                    if (data.success) {
                        const notificationList = document.getElementById("notificationList");
                        notificationList.innerHTML = '<p class="px-4 py-2 text-gray-600">No new notifications</p>';

                        const notificationCount = document.getElementById("notificationCount");
                        notificationCount.textContent = 0;
                    }
                })
                .catch((error) => console.error("Error marking notifications as read:", error));
        });
    } else {
        console.error("Mark All as Read button not found");
    }
});


document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Loaded');

    const postsFeed = document.getElementById('postsFeed');
    postsFeed.addEventListener('click', (event) => {
        const target = event.target;

        if (target.classList.contains('delete-post-btn')) {
            console.log('Delete button clicked:', target.dataset.id); // Debugging
        }

        if (target.classList.contains('edit-post-btn')) {
            console.log('Edit button clicked:', target.dataset.id); // Debugging
        }
    });
});

function deletePost(postId) {
    if (!confirm('Are you sure you want to delete this post?')) {
        return;
    }

    fetch(`/posts/${postId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        },
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Post deleted successfully');
                loadPosts(); // Reload posts
            } else {
                alert('Failed to delete post');
            }
        })
        .catch(error => console.error('Error deleting post:', error));
}

function editPost(postId) {
    console.log(`Edit button clicked for post: ${postId}`); // Debugging
    const postElement = document.querySelector(`[data-post-id="${postId}"]`);
    if (!postElement) {
        console.error(`Post element not found for post ID: ${postId}`);
        return;
    }

    // Log structure to debug
    console.log(postElement);

    const postContent = postElement.querySelector('.text-gray-700');
    if (!postContent) {
        console.error(`Post content not found for post ID: ${postId}`);
        return;
    }

    // Replace content with textarea
    const editTextarea = document.createElement('textarea');
    editTextarea.classList.add('w-full', 'p-2', 'border', 'rounded', 'mb-2');
    editTextarea.value = postContent.textContent.trim(); // Add trim for safety
    postContent.replaceWith(editTextarea);

    // Add Save and Cancel buttons
    const saveButton = document.createElement('button');
    saveButton.textContent = 'Save';
    saveButton.classList.add('bg-green-500', 'text-white', 'py-1', 'px-4', 'rounded', 'mr-2');

    const cancelButton = document.createElement('button');
    cancelButton.textContent = 'Cancel';
    cancelButton.classList.add('bg-red-500', 'text-white', 'py-1', 'px-4', 'rounded');

    postElement.appendChild(saveButton);
    postElement.appendChild(cancelButton);

    // Save logic
    saveButton.addEventListener('click', () => {
        const updatedContent = editTextarea.value.trim();
        if (!updatedContent) {
            alert('Post content cannot be empty.');
            return;
        }

        fetch(`/posts/${postId}`, {
            method: "PUT",
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ content: updatedContent }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    alert('Post updated successfully.');
                    loadPosts(); // Reload posts
                } else {
                    alert('Failed to update post.');
                }
            })
            .catch((error) => console.error('Error updating post:', error));
    });

    // Cancel logic
    cancelButton.addEventListener('click', () => {
        editTextarea.replaceWith(postContent);
        saveButton.remove();
        cancelButton.remove();
    });
}

document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Loaded');

    document.getElementById('postsFeed').addEventListener('click', (event) => {
        const target = event.target;

        if (target.classList.contains('delete-post-btn')) {
            const postId = target.dataset.id;
            console.log('Delete button clicked for post:', postId);
            deletePost(postId);
        }

        if (target.classList.contains('edit-post-btn')) {
            const postId = target.dataset.id;
            console.log('Edit button clicked for post:', postId);
            editPost(postId);
        }
    });
});

//Header dropdown
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM Content Loaded'); // Debugging

    const dropdownButton = document.getElementById('dropdownButton');
    const dropdownMenu = document.getElementById('dropdownMenu');

    if (dropdownButton && dropdownMenu) {
        dropdownButton.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent click from bubbling up
            dropdownMenu.classList.toggle('hidden'); // Toggle visibility
        });

        // Close the dropdown if clicked outside
        document.addEventListener('click', (event) => {
            if (!dropdownMenu.contains(event.target) && !dropdownButton.contains(event.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    } else {
        console.error('Dropdown button or menu not found'); // Debugging
    }
});