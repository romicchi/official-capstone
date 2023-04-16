@include('layout.adminnavlayout')
@yield('adminnavbar')


<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">

@if (is_countable($users) && count($users) > 0)
<!-- Search Bar -->
<div class="d-flex justify-content-end my-1">
  <form class="form-inline" type="GET" action="{{ route('search')}}">
    <div class="input-group" style="max-width: 250px;">
      <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn">
      <button class="btn btn-success rounded-0" type="submit" id="search-btn">Search</button>
    </div>
  </form>
</div>

<!-- Admin Table -->
<h2>Admin Table</h2>
<form class="table-responsive table-wrapper" id="admin-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        @if ($user->role == 'admin')
          <tr>
            <td>{{ $user->id }}</td> 
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td><a type="submit" class="btn btn-primary" href="{{ 'adminedit/' . $user->id }}">Edit</a></td>
            <td><a type="submit" class="btn btn-danger" href="{{ 'delete/' . $user->id }}">Delete</a></td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>
</form>

<!-- Teacher Table -->
<h2>Teacher Table</h2>
<form class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        @if ($user->role == 'teacher')
          <tr>
            <td>{{ $user->id }}</td> 
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td><a type="submit" class="btn btn-primary" href="{{ 'adminedit/' . $user->id }}">Edit</a></td>
            <td><a type="submit" class="btn btn-danger" href="{{ 'delete/' . $user->id }}">Delete</a></td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>
</form>

<!-- Student Table -->
<h2>Student Table</h2>
<form class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Role</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($users as $user)
        @if ($user->role == 'student')
          <tr>
            <td>{{ $user->id }}</td> 
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td><a type="submit" class="btn btn-primary" href="{{ 'adminedit/' . $user->id }}">Edit</a></td>
            <td><a type="submit" class="btn btn-danger" href="{{ 'delete/' . $user->id }}">Delete</a></td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>
</form>

@else
  <form class="input-group d-flex justify-content-end my-2" type="GET" action="{{ route('search') }}">
    <input type="search" class="form-control rounded-0" name="query" placeholder="search user" aria-label="Search" aria-describedby="search-btn" style="max-width: 250px;">
    <div class="input-group-append">
      <button class="btn btn-success rounded-0" type="submit" id="search-btn">Search</button>
    </div>
  </form>
  <p>No users found</p>
@endif




