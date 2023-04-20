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
    <section class="resource-upload">
  <h2>Upload Resource</h2>
  <form>
    <div class="form-group">
      <label for="title">Title:</label>
      <input type="text" id="title" name="title" class="form-control" required>
    </div>
    <div class="form-group">
      <label for="description">Description:</label>
      <textarea id="description" name="description" class="form-control" rows="3" required></textarea>
    </div>
    <div class="form-group">
      <label for="file">Select file:</label>
      <input type="file" id="file" name="file" class="form-control-file" required>
    </div>
    <button type="submit" class="btn btn-primary">Upload Resource</button>
  </form>
</section>

<section class="resource-management">
  <h2>Resource Management</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Add Resource</h4>
          <form>
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
              <label for="author">Author</label>
              <input type="text" class="form-control" id="author" name="author">
            </div>
            <div class="form-group">
              <label for="description">Description</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
              <label for="file">File</label>
              <input type="file" class="form-control-file" id="file" name="file">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>


</main>
<footer>
	<p>Copyright &copy; 2023 Librar-e. All rights reserved.</p>
</footer>
    </body>
</html>
