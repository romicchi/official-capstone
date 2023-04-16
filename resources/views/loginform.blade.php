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
</head>
<body>
	<div class="container"> 
	<div class="mt-5 message">
  @if($errors->any())
    <div class="col-12">
      @foreach($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
      @endforeach
    </div>
  @endif

  <!-- Session Error -->
  @if(session()->has('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
  @endif

  <!-- Success Message -->
  @if(session()->has('success'))
    <div class="alert alert-success">{{session('success')}}</div>
  @endif
</div>
		<div class="col">
			<form action="{{ route('login.post') }}" method="post">
				@csrf
                <h1>Login</h1>
				<div class="form-group">
					<label for="email">Username/Email:</label>
					<input type="text" class="form-control" id="email" name="email" placeholder="Enter Username/Email" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
				</div>

				<button type="submit" class="btn btn-primary"<a href="{{ route('dashboard') }}">Login</a></button>
			

			<p>Don't have an account yet? <a href="/register">Sign Up</a></p>
            <p>Click for <a href="/adminaccess">Admin Access</a></p>
			<img src="{{ asset ('assets/img/logo.png') }}" alt="Logo" style="width: 10vw; height: 6vh;  display: block; margin-left: auto; margin-right: auto;">
        </form>
		</div>
	</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>