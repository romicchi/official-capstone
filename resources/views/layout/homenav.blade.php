<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/homenav.css') }}">
</head>

<body>
@section('navbar')
<nav class="navbar navbar-expand-lg">
    <a class="navbar-brand" href="{{ url('/') }}">
        <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-image">
    </a>
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
@show
<script src="{{ asset('assets/bootstrap/js/bootstrap.js') }}"></script>
</body>
