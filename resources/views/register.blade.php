@include('layout.homenav')

<!DOCTYPE html>
<html>
<head>
	<title>Register Account</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset ('css/register.css') }}">
</head>
<body>
  
<div class="container">
  <div class="col">
    <form action="{{ route('register.post') }}" method="post" enctype="multipart/form-data">
      @csrf
      
      <!-- Error Message -->
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

      
    <h1>Register</h1>
      <div class="form-group">
        <label for="firstname">Firstname:</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter Firstname" required>
      </div>
      <div class="form-group">
        <label for="lastname">Lastname:</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Lastname" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
      </div>
      <div class="form-group">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
      </div>
      <div class="form-group">
        <label for="role">I am a:</label>
        <select class="form-control" id="role" name="role">
          <option value="1">Student</option>
          <option value="2">Teacher</option>
        </select>
      </div>
      <div class="form-group row">
                            <label for="id" class="col-form-label">School ID: </label>
                            <div class="col-md-9">
                                <input id="id" type="file" class="form-control @error('id') is-invalid @enderror" name="id" required autofocus>
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
      <button type="submit" class="btn btn-primary my-2">Sign Up</button>
      <p><a href="/login">Already have an account?</a></p>
    </form>
  </div>
</div>
</body>
</html>