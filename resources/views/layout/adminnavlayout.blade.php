<head>   
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"> 
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin1.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>

<!-- NAV BAR -->
@section('adminnavbar')
<div class="container-fluid">
    <div class="row">
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top col-12 col-lg-2">
            <a class="navbar-brand" href="{{ route('adminpage') }}">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-image">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @php
            $currentRoute = \Illuminate\Support\Facades\Request::route()->getName();
            @endphp
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link {{ $currentRoute === 'adminpage' ? 'active' : 'inactive' }}" href="{{ route('adminpage') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <li class="nav-item dropend">

                            <a class="nav-link dropdown-toggle {{ $currentRoute === 'show.disciplines' ? 'active' : 'inactive' }}" id="dropdown01" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-book fa-xs"></i>
                            Resources
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            @foreach ($colleges as $college)
                                <li class="dropdown dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" id="dropdown{{ $college->id }}"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $college->collegeName }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdown{{ $college->id }}">
                                        @foreach ($college->disciplines as $discipline)
                                            <li><a class="dropdown-item" href="{{ route('show.disciplines', ['college_id' => $college->id, 'discipline_id' => $discipline->id]) }}">{{ $discipline->disciplineName }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link {{ $currentRoute === 'usermanage' ? 'active' : 'inactive' }}" href="{{ route('usermanage') }}?activeTab=existing">
                        <i class="fas fa-users fa-xs"></i>
                        Manage User</a>
                    </li>

                    <!-- Feature/Button available for the admin role only -->
                    @if (auth()->user()->role_id === 3)
                    <li class="nav-item">
                    <a class="nav-link {{ $currentRoute === 'adminresourcemanage' ? 'active' : 'inactive' }}" href="{{ route('adminresourcemanage') }}">
                            <i class="fas fa-book fa-xs"></i>
                            Manage Resources</a>
                    <li class="nav-item">

                    <li class="nav-item">
                        <a class="nav-link {{ $currentRoute === 'academics.index' ? 'active' : 'inactive' }}" href="{{ route('academics.index') }}?activeTab=colleges">
                            <i class="fas fa-graduation-cap fa-xs"></i>
                            Academics</a>
                    <li class="nav-item">
                    @endif

                    <li class="nav-item">
                        <a class="nav-link {{ $currentRoute === 'activity-log' ? 'active' : 'inactive' }}" href="{{ route('activity-log') }}?activeTab=colleges">
                            <i class="fas fa-clipboard-list fa-xs"></i>
                            Activity Logs</a>
                    <li class="nav-item">

                    <li class="nav-item">
                        <a class="nav-link {{ $currentRoute === 'administrator.login' ? 'active' : 'inactive' }}" href="{{ route('administrator.login') }}">
                            <i class="fas fa-window-restore fa-xs"></i>
                            Backup & Restore</a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt fa-xs"></i> Logout
                        </a>
                    </li>
                    

                </ul>
            </div>
        </nav>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<script>

    $(document).ready(function () {
        $('.dropdown-submenu a.dropdown-toggle').on("click", function (e) {
            $(this).next('ul').toggle();
            e.stopPropagation();
            e.preventDefault();
        });
    });

    // Academics -> Direct display the College table instead of displaying the three table.
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const activeTab = urlParams.get('activeTab') || '{{ $activeTab ?? '' }}';
        if (activeTab) {
            openTab(event, activeTab);
        } else {
            openTab(event, 'colleges'); // Default to 'colleges' tab
        }
    });
</script>
@show
