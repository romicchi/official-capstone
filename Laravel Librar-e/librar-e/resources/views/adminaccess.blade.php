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
		<div class="col">
			<form method="post">
                <h1>Admin Access</h1>
				<div class="form-group">
					<label for="username">Email:</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Enter Email" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
				</div>

				<button type="submit" class="btn btn-primary">Login</button>
			
            <p>Click for <a href="/loginform">User Access</a></p>

			<img src="{{ asset ('assets/img/logo.png') }}" alt="Logo" style="width: 10vw; height: 6vh;  display: block; margin-left: auto; margin-right: auto;">

        </form>
		</div>
	</div>
</body>

