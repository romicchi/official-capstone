@include('layout.usernav')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css')}}">
      </head>
    <body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
  <header>
		<div class="dashboard">
    <h2>Welcome to the User Dashboard, <strong>{{ Auth::user()->name }}</strong></h2>
			<p>Here you can manage your account, view statistics, history, and more.</p>
		</div>
	</header>
	<main>
    
    <section class="personal-info">
        <h2>Personal Information</h2>
        <p>Name: {{ Auth::user()->name }}</p>
        <p>Email: {{ Auth::user()->email }}</p>
    </section>
		
    <section class="overview">
			<h2>Overview</h2>
			<div class="stats">
				<div class="stat">
					<h3>Total Users</h3>
					<p>1500</p>
				</div>
				<div class="stat">
					<h3>Total Resources</h3>
					<p>2000</p>
				</div>
				<div class="stat">
					<h3>Active Users</h3>
					<p>1000</p>
				</div>
				<div class="stat">
					<h3>Inactive Users</h3>
					<p>500</p>
				</div>
			</div>
		</section>


</main>
<footer>
	<p>Copyright &copy; 2023 Librar-e. All rights reserved.</p>
</footer>
    </body>
</html>
