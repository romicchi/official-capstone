@include('layout.adminnavlayout')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Access</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->
        
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/admin1.css')}}">
      </head>
    <body>
      <!-- Nav Bar -->
      @yield('adminnavbar')

      <!-- Content -->
      <header>
		<div class="logo">
    <h2>Welcome to the Librar-e Admin Dashboard</h2>
			<p>Here you can manage user accounts, add or edit resources, generate reports and more.</p>
		</div>
	</header>
	<main>
		<section class="dashboard">
			<h2>Welcome to the Librar-e Admin Dashboard</h2>
			<p>Here you can manage user accounts, add or edit resources, generate reports and more.</p>
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
		
		<section class="resource-usage">
  <h2>Resource Usage Statistics</h2>
  <table>
    <thead>
      <tr>
        <th>Resource</th>
        <th>Number of Views</th>
        <th>Number of Downloads</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>Resource 1</td>
        <td>100</td>
        <td>50</td>
      </tr>
      <tr>
        <td>Resource 2</td>
        <td>50</td>
        <td>20</td>
      </tr>
      <tr>
        <td>Resource 3</td>
        <td>75</td>
        <td>30</td>
      </tr>
      <!-- Add more rows as needed -->
    </tbody>
  </table>
</section>

		<section class="reports">
			<h2>Generate Reports</h2>
			<form>
				<label for="start-date">Start Date:</label>
				<input type="date" id="start-date" name="start-date">
				<label for="end-date">End Date:</label>
				<input type="date" id="end-date" name="end-date">
				<button type="submit">Generate Report</button>
			</form>
		</section>

</main>
<footer>
	<p>Copyright &copy; 2023 Librar-e. All rights reserved.</p>
</footer>
    </body>
</html>