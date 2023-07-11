        
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/admin1.css')}}">

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
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminpage') }}">Dashboard</a>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdown01" data-bs-toggle="dropdown"
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
                        <a class="nav-link" href="{{ route('usermanage') }}">Manage User</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminresourcemanage') }}">Manage Resources</a>
                    <li class="nav-item">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('academics.index') }}">Academics</a>
                    <li class="nav-item">

                    <a class="nav-link" href="#"
                        onclick="confirmLogout()">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<script>
    function confirmLogout() {
        if (confirm('Are you sure you want to logout?')) {
            window.location.href = '{{ route('logout') }}';
        }
    }
</script>
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
</script>
@show
