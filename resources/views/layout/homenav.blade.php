<head>
<title>@yield('title')</title>

<link rel="stylesheet" type="text/css" href="{{ asset ('css/homenav.css') }}">
</head>

@section('navbar')
<nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ url('/') }}">Librar-e</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @if (Route::has('login'))
                <li class="nav-item">
                    @auth
                    <a class="nav-link" href="{{ url('/dashboard') }}">Home</a>
                    @else
                    <a class="nav-link" href="{{ route('login') }}">Log in</a>

                    <!-- @if (Route::has('register'))
                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @endif -->
                    @endauth
                </li>
                @endif
            </ul>
        </div>
    </nav>
@show