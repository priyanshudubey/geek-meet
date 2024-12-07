<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="user-id" content="{{ auth()->id() }}">
    <title>@yield('title', 'Geek Meet')</title>
    @vite(['resources/css/app.css', 'resources/js/home.js'])
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
    />
</head>
<body class="bg-gray-100">
    <!-- Header -->
    @include('partials.header')

    <!-- Main Content -->
    <main class="container mx-auto mt-10 px-4">
        @yield('content')
    </main>
</body>
</html>
