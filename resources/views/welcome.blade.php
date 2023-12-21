@include('layout.homenav')
@extends('layout.chatbotlayout')
@extends('layout.app')

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>GENER | Welcome</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="antialiased">

    <!-- Jumbotron -->
    <div class="jumbotron" data-aos="fade-down" style="margin-top: 0;">
    <img src="{{ asset('assets/img/Background.png') }}" class="img-fluid" alt="Background Image" loading="lazy">
</div>

    <!-- About Section -->
    <section class="about" id="about-container">
        <div class="container">
            <div class="row m-a-0">
                <h2 class="mb-5 text-center">About</h2>
                <!-- Image Block -->
                <div class="col-md-6 p-a-0">
                    <div class="img-wrap shadow" style="background-image: url({{ asset('assets/img/learning.jpg') }})" loading="lazy"></div>
                </div>
                <!-- Text Block -->
                <div class="col-md-6 shadow bg-edit bg-blue text-white spotlight-text center-md">
                    <div class="vertical-center-rel">
                        <h6 class="text-uppercase f-w-900" style="visibility: visible;" data-aos="fade-up">Why Use GENER?</h6>
                        <h3 class="f-w-900 m-b-md" style="visibility: visible;" data-aos="fade-up">We're transforming the way people learn.</h3>
                        <p class="m-b-md" data-aos="fade-up">By promoting collaboration, tailored learning materials, ensured accessibility, and enabled scalability, 
                            GENER empowers educators to take advantage of the high-quality resources and provides learners with a flexible, diverse, and ever-expanding repository of knowledge, thereby reshaping the landscape of modern education.</p>
                        <a href="{{ route('register') }}" class="btn btn-ghost smooth-scroll text-uppercase" data-aos="zoom-in">Register Now!</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features-container">
        <div class="container">
            <h2 class="mb-5 text-center">Features</h2>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-5 mb-lg-0">
                        <div class="card-body" data-aos="zoom-in-up">
                            <h5 class="card-title text-center">Easy Access</h5>
                            <p class="card-text text-center">Provide students with easy access to educational resources related to certain courses offered in LNU.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card mb-5 mb-lg-0">
                        <div class="card-body" data-aos="zoom-in-up">
                            <h5 class="card-title text-center">Sharing</h5>
                            <p class="card-text text-center">The platform enables teachers to easily share educational materials with their students, such as lecture notes, study guides, and reading assignments.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body" data-aos="zoom-in-up">
                            <h5 class="card-title text-center">Discovery</h5>
                            <p class="card-text text-center">Enables students to quickly find the learning resources they need. Students can search by title, keyword, or discipline to locate relevant materials.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Chatbot Section -->
    <section class="chatbot">
        <div class="container" id="chatbot-container">
            <h2 class="mb-5 text-center">Talk to GENER</h2>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="text-center">
                        <div class="gener">
                            <a href="{{ route('login') }}">
                                <img class="gener-image" src="{{ asset('assets/img/gener2.png') }}" alt="logo" class="img-fluid" data-aos="zoom-in" width="250">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white py-3" id="footer-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-2 mb-lg-0">
                    <h5><strong>About Us</strong></h5>
                    <p class="mb-0">{{ config('app.name') }} is an acronym for GEnerative Nexus of Educational Resources conceptualized by Dr. Las Johansen B. Caluza. It is an AI-Powered Learning Object Repository System made for LNU students and teachers.</p>
                </div>
                <div class="col-lg-3">
                    <h5><strong>Links</strong></h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Home</a></li>
                        <li><a href="#about-container">About</a></li>
                        <li><a href="#features-container">Features</a></li>
                        <li><a href="#chatbot-container">Chatbot</a></li>
                        <li><a href="#footer-container">Address</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5><strong>Address</strong></h5>
                    <p>Leyte Normal University<br>Paterno St, Downtown, Tacloban City, Leyte, 6500</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center mt-3">
                    <p>&copy; 2023 Leyte Normal University. All Rights Reserved.</p>
                    <p>LNU GENER V.1.0.0 | Maintained and Managed by PancitCantonEnjoyers</p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

<script>
    AOS.init();
</script>
