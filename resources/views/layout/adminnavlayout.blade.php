        
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/admin1.css')}}">

<!-- NAV BAR -->
@section('adminnavbar')
<div class="container-fluid">
        <div class="row">
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top col-12 col-lg-2">
            <a class="navbar-brand" href="#">Librar-e</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav flex-column">
              <li class="nav-item">
                  <a class="nav-link" href="{{route('adminpage')}}">Dashboard</a>
                </li>

                <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" id="dropdown01" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <img class="images" src="">Resources
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="dropdown01">
                            <li class="dropdown dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" id="dropdown02"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CME</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown02">
                                    <li><a class="dropdown-item" href="#">course item 1</a></li>
                                    <li><a class="dropdown-item" href="#">course item 2</a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#" id="dropdown03"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">CAS</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown03">
                                    <li><a class="dropdown-item" href="/bsit">BSIT</a></li>
                                    <li><a class="dropdown-item" href="/bacomm">BACOMM</a></li>
                                    <li><a class="dropdown-item" href="/bacomm">BAEL</a></li>
                                    <li><a class="dropdown-item" href="/bacomm">BAPOS</a></li>
                                    <li><a class="dropdown-item" href="/bacomm">BLIS</a></li>
                                    <li><a class="dropdown-item" href="/bacomm">BMME</a></li>
                                    <li><a class="dropdown-item" href="/bacomm">BS BIOLOGY</a></li>
                                    <li><a class="dropdown-item" href="/bacomm">BSSW</a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-submenu">
                                <a class="dropdown-item dropdown-toggle" href="#" id="dropdown04"
                                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">COE</a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown04">
                                    <li><a class="dropdown-item" href="#">course item 1</a></li>
                                    <li><a class="dropdown-item" href="#">course item 2</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>


                <li class="nav-item">
                  <a class="nav-link" href="{{route('usermanage')}}">Manage User</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{route('adminresourcemanage')}}">Manage Resources</a>
                  <li class="nav-item">
                  <a class="nav-link" href="#" onclick="confirmLogout()" style="cursor: pointer;"><img class="images1" src="{{ asset ('assets/img/logout.png') }}" style="width: 1vw;
                    height: 100%;
                    object-fit: cover;">Logout</a>
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
              <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
          <script>
              $(document).ready(function() {
              $('.dropdown-submenu a.dropdown-toggle').on("click", function(e) {
              $(this).next('ul').toggle();
              e.stopPropagation();
              e.preventDefault();
            });
          });
          </script>
          <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
@endsection