<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geek Meet - Connect with Fellow Geeks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #6C63FF;
            --secondary-color: #4CAF50;
            --accent-color: #FF6B6B;
            --dark-bg: #2C3E50;
            --light-bg: #ECF0F1;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .hero-section {
            background: linear-gradient(rgba(44, 62, 80, 0.8), rgba(44, 62, 80, 0.8)), url('https://images.unsplash.com/photo-1517457373958-b7bdd4587205?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1169&q=80');
            background-size: cover;
            background-position: center;
        }
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        .btn-primary:hover {
            background-color: #5753D9;
            border-color: #5753D9;
        }
        .bg-custom-dark {
            background-color: var(--dark-bg);
        }
        .bg-custom-light {
            background-color: var(--light-bg);
        }
        .text-custom-accent {
            color: var(--accent-color);
        }
        .card {
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
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
    </style>
</head>
<body>
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
                        <li class="nav-item"><a class="nav-link" href="#features">Features</a></li>
                        <li class="nav-item"><a class="nav-link" href="#about">About</a></li>
                        <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <main>
        <section class="hero-section text-white py-5 mb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <h2 class="display-4 mb-4">Connect with Fellow Geeks</h2>
                        <p class="lead mb-4">Join Geek Meet and discover a community of like-minded individuals who share your passions.</p>
                        <a href="/signup" class="btn btn-primary btn-lg">Sign Up Now</a>
                        <a href="/login" class="btn btn-primary btn-lg">Log In</a>
                    </div>
                    <div class="col-md-6">
                        <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Geeks collaborating" class="img-fluid rounded shadow-lg">
                    </div>
                </div>
            </div>
        </section>

        <section id="features" class="py-5 bg-custom-light">
            <div class="container">
                <h2 class="text-center mb-5">Features</h2>
                <div class="row">
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-users fa-3x mb-3 text-custom-accent"></i>
                                <h3 class="card-title">Meet New Friends</h3>
                                <p class="card-text">Connect with geeks who share your interests and make lasting friendships.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-comments fa-3x mb-3 text-custom-accent"></i>
                                <h3 class="card-title">Chat</h3>
                                <p class="card-text">Engage in real-time conversations with fellow geeks on various topics.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow">
                            <div class="card-body text-center">
                                <i class="fas fa-image fa-3x mb-3 text-custom-accent"></i>
                                <h3 class="card-title">Share Photos</h3>
                                <p class="card-text">Upload and share your favorite geeky moments with the community.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="about" class="py-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-4 mb-md-0">
                        <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1170&q=80" alt="Geeks collaborating" class="img-fluid rounded shadow">
                    </div>
                    <div class="col-md-6">
                        <h2 class="mb-4 text-custom-accent">About Geek Meet</h2>
                        <p class="lead">Geek Meet is the ultimate social platform for geeks, nerds, and enthusiasts of all kinds. We believe in creating a space where you can be yourself, share your passions, and connect with like-minded individuals from around the world.</p>
                        <p>Whether you're into coding, gaming, sci-fi, anime, or any other geeky pursuit, Geek Meet is the place for you to find your tribe and engage in meaningful conversations.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-5 bg-custom-light">
            <div class="container">
                <h2 class="text-center mb-5">Contact Us</h2>
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <form>
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" required>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-custom-dark text-white py-4">
        <div class="container text-center">
            <p>&copy; 2023 Geek Meet. All rights reserved.</p>
            <div class="mt-3">
                <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                <a href="#" class="text-white"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>