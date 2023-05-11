        
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
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
@endsection