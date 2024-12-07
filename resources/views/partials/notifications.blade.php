<div class="relative mr-4">
    <button
        id="notificationButton"
        class="relative bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded focus:outline-none"
    >
        <i class="fas fa-bell"></i>
        <span id="notificationCount" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center">0</span>
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
