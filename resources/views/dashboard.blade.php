@extends('layout.usernav')
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
		<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

            <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

      </head>
      <style>
          .border-left-primary {
              border-left: 0.25rem solid #4e73df !important;
            }
            
            .border-left-success {
                border-left: 0.25rem solid #1cc88a !important;
            }
            
            .border-left-info {
                border-left: 0.25rem solid #36b9cc !important;
            }
            
            .border-left-warning {
                border-left: 0.25rem solid #f6c23e !important;
            }
      </style>
    <body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
  <header>
		<div class="dashboard">
    <h2>Welcome to Dashboard, <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong></h2>
		</div>
	</header>
	<main>
    
    <!-- <section class="personal-info">
        <h2>Personal Information</h2>
        <p>Name: {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</p>
        <p>Email: {{ Auth::user()->email }}</p>
    </section> -->
		
<!-- Content Row -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card h-100 card-lift">
            <!-- card body -->
            <div class="card-body">
                <!-- heading -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="mb-0">Projects</h4>
                    </div>
                    <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                        <i  data-feather="briefcase" height="20" width="20"></i>
                    </div>
                </div>
                <!-- project number -->
                <div class="lh-1">
                    <h1 class=" mb-1 fw-bold">18</h1>
                    <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card h-100 card-lift">
            <!-- card body -->
            <div class="card-body">
                <!-- heading -->
                <div class="d-flex justify-content-between align-items-center
                mb-3">
                <div>
                    <h4 class="mb-0">Active Task</h4>
                </div>
                <div class="icon-shape icon-md bg-primary-soft text-primary
                rounded-2">
                <i  data-feather="list" height="20" width="20"></i>
            </div>
        </div>
        <!-- project number -->
        <div class="lh-1">
            <h1 class="  mb-1 fw-bold">132</h1>
            <p class="mb-0"><span class="text-dark me-2">28</span>Completed</p>
        </div>
    </div>
</div>
</div>
<div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
    <!-- card -->
    <div class="card h-100 card-lift">
        <!-- card body -->
        <div class="card-body">
            <!-- heading -->
            <div class="d-flex justify-content-between align-items-center
            mb-3">
            <div>
                <h4 class="mb-0">Teams</h4>
            </div>
            <div class="icon-shape icon-md bg-primary-soft text-primary
            rounded-2">
            <i  data-feather="users" height="20" width="20"></i>
        </div>
    </div>
    <!-- project number -->
    <div class="lh-1">
        <h1 class="  mb-1 fw-bold">12</h1>
        <p class="mb-0"><span class="text-dark me-2">1</span>Completed</p>
    </div>
</div>
</div>
</div>

<div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
    <!-- card -->
    <div class="card h-100 card-lift">
        <!-- card body -->
        <div class="card-body">
            <!-- heading -->
            <div class="d-flex justify-content-between align-items-center
            mb-3">
            <div>
                <h4 class="mb-0">Productivity</h4>
            </div>
            <div class="icon-shape icon-md bg-primary-soft text-primary
            rounded-2">
            <i  data-feather="target" height="20" width="20"></i>
        </div>
    </div>
    <!-- project number -->
    <div class="lh-1">
        <h1 class="  mb-1 fw-bold">76%</h1>
        <p class="mb-0"><span class="text-success me-2">5%</span>Completed</p>
    </div>
</div>
</div>
</div>
</div>
</div>
	
</main>
    </body>
    <footer>
	<p>Copyright &copy; 2023 {{config('app.name')}}. All rights reserved.</p>
</footer>
</html>
