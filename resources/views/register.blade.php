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
    <form method="post" enctype="multipart/form-data">
      <h1>Register</h1>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username" required>
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
        <label for="role">I am a:</label>
        <select class="form-control" id="role" name="role">
          <option value="student">Student</option>
          <option value="teacher">Teacher</option>
        </select>
      </div>
      <div class="form-group">
        <label for="school_id">School ID:</label>
        <input type="file" class="form-control-file" id="school_id" name="school_id" accept="image/*" required>
      </div>
      <button type="submit" class="btn btn-primary">Sign Up</button>
      <div><img class="logo" src="{{ asset ('assets/img/logo.png') }}" alt="Logo"></div>
    </form>
  </div>
</div>
</body>
</html>