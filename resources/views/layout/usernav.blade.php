@section('usernav')
    <head>
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
    </head>
      <div class="container-fluid">
        <div class="row">
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top col-12 col-lg-2">
            <a class="navbar-brand" href="#">{{config('app.name')}}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('dashboard') }}"> <img class="images1" src="{{ asset ('assets/img/dashboard.png') }}" style="width: 1vw;
                    height: 100%;
                    object-fit: cover;">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="dropdown01"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <img class="images" src="{{ asset ('assets/img/courses.png') }}">Courses</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="/bacomm">BACOMM</a>
                    <a class="dropdown-item" href="#">BEED</a>
                    <a class="dropdown-item" href="/bsit">BSIT</a>
                    <a class="dropdown-item" href="#">HRM</a>
                    <a class="dropdown-item" href="#">TM</a>
                  </div>
                </li>
                
                <li class="nav-item dropdown">
                  <a class="nav-link dropdown-toggle" id="dropdown2"
                  data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="imgages" src="{{ asset ('assets/img/personal.png') }}">Personal</a>
                  <div class="dropdown-menu" aria-labelledby="dropdown2">
                    <a class="dropdown-item" href="#">Notes History</a>
                    <a class="dropdown-item" href="{% url 'personal' %}">Study Journal</a>
                    <a class="dropdown-item" href="/favorites">Favorites</a>
                  </div>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route ('discussions.index') }}"><img class="images1" src="{{ asset ('assets/img/forum.png') }}">Forum</a>
                </li>
                @if (auth()->user()->role === 'teacher')
                <li class="nav-item">
                  <a class="nav-link" href="{{ url ('teacherupload') }}"><img class="images1" src="{{ asset ('assets/img/forum.png') }}">Upload files</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ url ('teachermanage') }}"><img class="images1" src="{{ asset ('assets/img/forum.png') }}">Manage</a>
                </li>
                @endif
                <li class="nav-item">
                  <a class="nav-link" href="{% url 'settings' %}"><img class="images1" src="{{ asset ('assets/img/setting.png') }}">Settings</a>
                </li>
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

          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
          <script>
            $(document).ready(function() {
              $('.dropdown-toggle').dropdown();
            });
          </script>
          <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
          <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
          <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
@endsection