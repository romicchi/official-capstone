<head>
<title>@yield('title')</title>

<link rel="stylesheet" type="text/css" href="{{ asset ('css/homenav.css') }}">
</head>

@section('navbar')
<nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="{{ url('/') }}">LNU: Resource Pool System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav">
                @if (Route::has('login'))
                <li class="nav-item">
                    @auth
                        @if (Auth::user()->role === 'admin')
                            <a class="nav-link" href="{{ route('adminpage') }}">Home</a>
                        @else
                            <a class="nav-link" href="{{ url('/dashboard') }}">Home</a>
                        @endif
                    @else
                        <a class="nav-link" href="{{ route('login') }}">Log in</a>
                    @endauth
                    </li>
                @endif
            </ul>
        </div>
    </nav>
@show