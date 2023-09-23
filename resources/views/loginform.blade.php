@include('layout.homenav')

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset ('css/login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  </head>
  <body>

  <div class="background" style="background-image: url({{ asset('assets/img/Background.png')}}" loading="lazy">
    <div class="container"> 
      <div class="mt-5 message">
        @if($errors->any())
        <div class="col-12">
          @foreach($errors->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
          @endforeach
        </div>
        @endif  
      </div>
      
      <div class="col">
        <form action="{{ route('login.post') }}" method="post">
          @csrf
          
          <!-- Success Message -->
          @if(session()->has('success'))
          <div class="alert alert-success">{{session('success')}}</div>
          @endif
          
          <!-- Session Error -->
          @if(session()->has('error'))
          <div class="alert alert-danger">{{session('error')}}</div>
          @endif
          <h1>Login</h1>
          <div class="form-group">
            <label for="email_or_student_number">Email:</label>
            <input type="text" class="form-control" id="email_or_student_number" name="email_or_student_number" placeholder="Email/Student Number" required>
          </div>
          <div class="form-group">
    <label for="password">Password:</label>
    <div class="input-group">
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
        <span class="input-group-text">
                <i class="fas fa-eye" id="togglePassword"></i>
            </span>
    </div>
</div>


          <div class="form-group">
            <div class="custom-control custom-checkbox">
              <input class="form-check-input" type="checkbox" name="remember" id="remember">
              <label class="form-check-label" for="remember">
                Remember Me
              </label>
            </div>
          </div>

          <button type="submit" id="login-button" class="btn btn-primary my-2"<a href="{{ route('dashboard') }}">Login</a></button>
          
          
          <p>Don't have an account yet? <a href="/register">Sign Up</a></p>
        </form>
      </div>
    </div>
  </div>
@include('loader')
<script src="{{ asset('js/loader.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script>
      const togglePassword = document.querySelector('#togglePassword');
      const password = document.querySelector('#password');
      
      togglePassword.addEventListener('click', function () {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
      });

      // JavaScript to Show Loader When Login Button is Clicked
      document.getElementById('login-button').addEventListener('click', function () {
        // Show the loader
        document.querySelector('.loader-container').style.display = 'block';
      });
    </script>
</body>
</html>

