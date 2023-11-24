<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/homenav.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/global.css') }}">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>
@section('navbar')
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-image">
        </a>

        <!-- Hides link when in login and register blade -->
        @if(!in_array(request()->route()->getName(), ['login', 'register'])) 
        <div class="navbar-links">
            <a href="#">Home</a>
            <a href="#about-container">About</a>
            <a href="#features-container">Features</a>
            <a href="#chatbot-container">Chatbot</a>
            <a href="#footer-container">Address</a>
        </div>
        @endif
        <div class=" justify-content-end" id="navbarNav">
            <ul class="navbar-nav flex-column">
                @guest
                    <a class="nav-link ml-auto" href="{{ route('login') }}">Log in</a>
                @else
                    @if (Auth::user()->role_id == 3)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('adminpage') }}">Home</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">Home</a>
                        </li>
                    @endif
                @endguest
            </ul>
        </div>
    </nav>
</body>
@show
