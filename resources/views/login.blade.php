<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Geek Meet</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6C63FF;
            --primary-dark: #5753D9;
            --secondary-color: #4CAF50;
            --accent-color: #FF6B6B;
            --dark-bg: #2C3E50;
            --light-bg: #ECF0F1;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }
        .text-primary {
            color: var(--primary-color) !important;
        }
        .bg-custom-dark {
            background-color: var(--dark-bg);
        }
        .bg-custom-light {
            background-color: var(--light-bg);
        }
        .navbar-brand {
            font-size: 2rem;
            font-weight: bold;
            color: var(--accent-color) !important;
            transition: all 0.3s ease;
        }
        .navbar-brand:hover {
            transform: scale(1.05);
        }
        .navbar-brand i {
            font-size: 2.5rem;
            vertical-align: middle;
        }
        .nav-link {
            font-size: 1.1rem;
            margin-left: 1rem;
        }
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.5rem;
            }
            .navbar-brand i {
                font-size: 2rem;
            }
        }
        .text-accent {
            color: var(--accent-color);
        }
    </style>
</head>
<body class="bg-custom-light">
    <header class="bg-custom-dark text-white py-3">
        <div class="container">
            <nav class="navbar navbar-expand-md navbar-dark">
                <a class="navbar-brand d-flex align-items-center" href="/">
                    <i class="fas fa-laptop-code me-3"></i>
                    <span>Geek Meet</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                        {{-- <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li> --}}
                    </ul>
                </div>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h2 class="card-title text-center mb-4">
                            <span class="text-black">Log In for</span> 
                            <span class="text-accent">Geek Meet</span>
                        </h2>
                        <form action="{{ route('login') }}" method="POST" id="loginForm">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">Log In</button>
                            </div>
                        </form>
                        <p class="text-center mt-4">
                            Don't have an account? <a href="/signup" class="text-primary">Sign up</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
