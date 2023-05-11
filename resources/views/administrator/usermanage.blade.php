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

<!-- Add User Button -->
<a href="{{ route('adminadd') }}" class="btn btn-primary">ADD USER</a>

<!-- Admin Table -->
<h2>Admin</h2>
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

<!-- Department Chair Table -->
<h2>Department Chair</h2>
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
        <!-- If empty this message will display -->
        @if ($users->where('role', 'departmentchair')->isEmpty())
        <tr>
          <td colspan="6"><strong>No departmentchairs inside the table</strong></td>
        </tr>
        @endif
      @foreach ($users as $user)
        @if ($user->role == 'departmentchair')
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

<!-- Program Coordinator Table -->
<h2>Program Coordinator</h2>
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
      <!-- If empty this message will display -->
        @if ($users->where('role', 'programcoordinator')->isEmpty())
        <tr>
          <td colspan="6"><strong>No programcoordinators inside the table</strong></td>
        </tr>
        @endif
      @foreach ($users as $user)
        @if ($user->role == 'programcoordinator')
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
<h2>Teacher</h2>
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
        <!-- If empty this message will display -->
        @if ($users->where('role', 'teacher')->isEmpty())
        <tr>
          <td colspan="6"><strong>No teachers inside the table</strong></td>
        </tr>
        @endif
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
<h2>Student</h2>
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
        <!-- If empty this message will display -->
        @if ($users->where('role', 'student')->isEmpty())
        <tr>
          <td colspan="6"><strong>No students inside the table</strong></td>
        </tr>
        @endif
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
<div class="d-flex justify-content-end my-1">
  <form class="form-inline" type="GET" action="{{ route('search')}}">
    <div class="input-group" style="max-width: 250px;">
      <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn">
      <button class="btn btn-success rounded-0" type="submit" id="search-btn">Search</button>
    </div>
  </form>
</div>
  <p>No users found</p>
@endif




