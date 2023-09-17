        <head>            
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/admin1.css')}}">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

                            <a class="nav-link dropdown-toggle {{ $currentRoute === 'show.subjects' ? 'active' : 'inactive' }}" id="dropdown01" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">

                            <img class="images" src="">Resources
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            @foreach ($colleges as $college)
                                <li class="dropdown dropdown-submenu">
                                    <a class="dropdown-item dropdown-toggle" id="dropdown{{ $college->id }}"
                                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ $college->collegeName }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdown{{ $college->id }}">
                                        @foreach ($college->courses as $course)
                                            <li><a class="dropdown-item" href="{{ route('show.subjects', ['course_id' => $course->id]) }}">{{ $course->courseName }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </li>                    

                    <li class="nav-item">
                    <a class="nav-link {{ $currentRoute === 'usermanage' ? 'active' : 'inactive' }}" href="{{ route('usermanage') }}?activeTab=existing">Manage User</a>
                    </li>

                    <li class="nav-item">
                    <a class="nav-link {{ $currentRoute === 'adminresourcemanage' ? 'active' : 'inactive' }}" href="{{ route('adminresourcemanage') }}">Manage Resources</a>
                    <li class="nav-item">

                    <li class="nav-item">
                        <a class="nav-link {{ $currentRoute === 'academics.index' ? 'active' : 'inactive' }}" href="{{ route('academics.index') }}?activeTab=colleges">Academics</a>
                    <li class="nav-item">

                    <li class="nav-item">
                        <a class="nav-link {{ $currentRoute === 'administrator.login' ? 'active' : 'inactive' }}" href="{{ route('administrator.login') }}">Backup & Restore</a>
                    </li>

                    <!-- Divider -->
                    <hr class="sidebar-divider my-0">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">
                            <i class="fas fa-sign-out-alt"></i> Logout
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
