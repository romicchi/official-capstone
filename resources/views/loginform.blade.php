@include('layout.homenav')

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>GENER | Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset ('css/login.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/global.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  </head>
  <body>

  <div class="background" style="background-image: url('{{ asset('assets/img/Background.png') }}')" loading="lazy">
    <div class="container"> 
      
      <div class="col">
        <form action="{{ route('login.post') }}" method="post">
          @csrf
          
          <!-- Success Message -->
          @if(session()->has('success'))
          <div class="alert alert-success">{{session('success')}}</div>
          @endif
          
          <h2 class="font-poppins-bold">Login</h2>
          <div class="form-group">
            <label for="email_or_student_number">Email/Student ID:</label>
            <input type="text" class="form-control" id="email_or_student_number" maxlength="50" name="email_or_student_number" placeholder="Email/Student Number">
            @error('email_or_student_number')
            <small _ngcontent-irw-c66 class="text-danger">{{ $message }}</small>
            @enderror
          </div>
          <div class="form-group">
            <label for="password">Password:</label>
            <div class="input-group">
              <input type="password" class="form-control" id="password" maxlength="100" name="password" placeholder="Enter Password" autocomplete="off">
              <span class="input-group-text">
                <i class="fas fa-eye" id="togglePassword"></i>
              </span>
            </div>
          </div>
          @error('password')
          <small _ngcontent-irw-c66 class="text-danger">* Password is required.</small>
          @enderror
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
<script src="{{ asset('js/togglepass.js') }}"></script>
</body>
</html>

