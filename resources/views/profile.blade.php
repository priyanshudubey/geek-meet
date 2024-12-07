@extends('layouts.app')

@section('title', 'Profile - Geek Meet')

@section('content')
<div class="container mx-auto mt-10 px-4">
    <div class="bg-white shadow rounded-lg p-6">
        <!-- Profile Header -->
        <div class="flex items-center space-x-6 mb-6">
            <!-- Profile Picture -->
            <div>
                <img
                    class="w-24 h-24 rounded-full border-4 border-gray-200 shadow"
                    src="{{ Auth::user()->profile_picture ?? '/default-avatar.png' }}"
                    alt="Profile Picture"
                />
            </div>
            <!-- User Info -->
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ Auth::user()->name }}</h1>
                <p class="text-gray-600 text-sm">{{ Auth::user()->email }}</p>
                <p class="text-gray-500 mt-1">{{ Auth::user()->bio ?? 'No bio available.' }}</p>
            </div>
        </div>

        <!-- Update Profile Form -->
        <div class="mt-8">
            <h2 class="text-xl font-semibold text-gray-700">Update Profile</h2>
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6">
                @csrf
                @method('PUT')

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-600">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        value="{{ Auth::user()->name }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        value="{{ Auth::user()->email }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    />
                </div>

                <!-- Bio -->
                <div class="mb-4">
                    <label for="bio" class="block text-sm font-medium text-gray-600">Bio</label>
                    <textarea
                        name="bio"
                        id="bio"
                        rows="4"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                    >{{ Auth::user()->bio }}</textarea>
                </div>

                <!-- Profile Picture -->
                <div class="mb-6">
                    <label for="profile_picture" class="block text-sm font-medium text-gray-600">Profile Picture</label>
                    <input
                        type="file"
                        name="profile_picture"
                        id="profile_picture"
                        class="mt-1 block w-full"
                    />
                </div>

                <!-- Save Button -->
                <div class="flex justify-end">
                    <button
                        type="submit"
                        class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700"
                    >
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
