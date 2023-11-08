@extends('layout.usernav')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GENER | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css')}}">
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

<body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
    <header>
      <div class="dashboard">
          <h2>Welcome, <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong></h2>
		</div>
    </header>
	<main>
		
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

<div class="row">
    <!-- Most Favorite Resources Table -->
    <div class="col-md-12 col-lg-6">
        <div class="table-container shadow">
            <p class="h4 mb-0 text-gray-800 text-center mb-2">Top Resources</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Author</th>
                        <th class="text-center">Favorited</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostFavoriteResources as $resource)
                        <tr>
                            <td class="text-center">{{ Str::limit($resource->title, 30) }}</td>
                            <td class="text-center">{{ $resource->author }}</td>
                            <td class="text-center">{{ $resource->favorited_by_count }}</td>
                            <td>
                                <a class="text-decoration" href="{{ route('resource.show', $resource->id) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Most Replied Discussions Table -->
    <div class="col-md-12 col-lg-6">
        <div class="table-container shadow">
            <p class="h4 mb-0 text-gray-800 text-center mb-2">Top Discussions</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Replied</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostRepliedDiscussions as $discussion)
                        <tr>
                            <td class="text-center">{{ Str::limit($discussion->title, 50) }}</td>
                            <td class="text-center">{{ $discussion->replies_count }}</td>
                            <td><a class="text-decoration" href="{{ route('discussions.show', $discussion->slug, ['id' => $discussion->id]) }}">View</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
	
</main>
<footer class="bg-dark text-white py-3" id="footer-container">
    <p>&copy; 2023 Leyte Normal University. All Rights Reserved.</p>
    <p>LNU GENER V.1.0.0 | Maintained and Managed by PancitCantonEnjoyers</p>
</footer>
</body>
</html>
