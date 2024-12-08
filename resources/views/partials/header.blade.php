<header class="bg-gray-800 text-white py-4">
    <div class="container mx-auto flex justify-between items-center px-4">
        <!-- Navbar Brand -->
        <a class="flex items-center text-[#FF6B6B] text-2xl font-bold hover:scale-105 transition-transform" href="/">
            <i class="fas fa-laptop-code mr-3"></i>
            <span>Geek Meet</span>
        </a>

        <!-- Notifications -->
        @include('partials.notifications')

        <!-- Navigation and User Controls -->
        <div class="relative flex items-center space-x-6">
            <!-- Home Button -->
            <a href="/home" 
               class="bg-gray-700 hover:bg-gray-600 text-white py-2 px-4 rounded focus:outline-none transition">
                Home
            </a>

            <!-- Profile Image -->
            @if (Auth::user()->profile && Auth::user()->profile->profile_image)
                <img 
                    src="{{ asset('storage/' . Auth::user()->profile->profile_image) }}" 
                    class="h-10 w-10 rounded-full object-cover border-2 border-gray-500"
                    alt="Profile Image"
                >
            @else
                <div 
                    class="h-10 w-10 rounded-full bg-gray-500 flex items-center justify-center text-sm font-bold"
                    title="No profile image"
                >
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            @endif

            <!-- User Name and Dropdown -->
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
    </div>
</header>
