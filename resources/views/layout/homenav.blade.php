<head>
    <title>@yield('title')</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/homenav.css') }}">
</head>
<body>

<body>
@section('navbar')
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-image">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav flex-column">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">Log in</a>
                </li>
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
@show
<script src="{{ asset('assets/bootstrap/js/bootstrap.js') }}"></script>
</body>


