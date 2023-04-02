<!DOCTYPE html>
<html>
<head>
	<title>Register Account</title>
	<!-- Add your stylesheet and other scripts here -->
	<!-- Bootstrap CDN -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
		<link rel="stylesheet" type="text/css" href="{{ asset ('css/register.css') }}">
	<!-- <style>
		html {
            background-color: #858585;
        }
        /* Position the form in the middle-right of the screen */
		form {
            border: 2px solid black;
            border-radius: 20px;
			position: absolute;
			top: 300px;
			right: 0%;
            left: 0%;
            padding: 50px 30px;
            margin: 5% 20%;
			transform: translateY(-50%);
            background-color: #F0F0F0;
            
		}
	</style> -->
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
      <div><img src="logo.png" alt="Logo"></div>
    </form>
  </div>
</div>
</body>
</html>