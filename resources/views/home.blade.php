@extends('layouts.app')

@section('title', 'Home - Geek Meet')

@section('content')
    <h2 class="text-sky-500 text-2xl font-semibold mb-4">Hello, {{ Auth::user()->name }}!</h2>
    <p class="text-gray-700 text-lg mb-6">Explore, connect, and share your passion with fellow tech enthusiasts.</p>

    <!-- Create Post Section -->
    @include('partials.create-post')

    <!-- Posts Feed -->
    @include('partials.posts', ['posts' => $posts])
    
@endsection