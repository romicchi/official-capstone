@include('layout.adminnavlayout')
@yield('adminnavbar')


<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">

@if (is_countable($users) && count($users) > 0)
<!-- Search Bar -->
<div class="d-flex justify-content-end my-1">
  <form class="form-inline" type="GET" action="{{ route('search')}}">
    <div class="input-group" style="max-width: 250px;">
      <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn">
      <button class="btn btn-primary rounded-0" type="submit" id="search-btn">Search</button>
    </div>
  </form>
</div>

<!-- Add User Button -->
<a href="{{ route('adminadd') }}" class="btn btn-primary">ADD USER</a>

<!-- Unverified Users Table -->
<h2>Pending Users</h2>
<form class="table-responsive table-wrapper" id="admin-table" method="post" action="{{ route('verify-users.post') }}">
  @csrf
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Lastname</th>
        <th>Firstname</th>
        <th>Email</th>
        <th>Role</th>
        <th>Verified</th>
        <th>Approve</th>
        <th>Reject</th>
      </tr>
    </thead>
    <tbody>
      <!-- If empty this message will display -->
      @if ($users->where('verified', false)->isEmpty())
        <tr>
          <td colspan="6"><strong>No unverified users inside the table</strong></td>
        </tr>
      @else     
      @foreach ($users as $user)
        @if ($user->verified == '0')
          <tr>
            <td>{{ $user->id }}</td> 
            <td>{{ $user->lastname }}</td>
            <td>{{ $user->firstname }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td>
              @if ($user->Verified == 1)
              <span class="badge badge-success badge-lg" style="color: green;">Approved</span>
              @else
              <span class="badge badge-warning badge-lg" style="color: red;">Pending</span>
              @endif
            </td>
            <td>
              <button type="submit" name="verified_users[]" value="{{ $user->id }}" class="btn btn-primary">Approve</button>
            </td>
            <td>
              <button type="submit" name="rejected_users[]" value="{{ $user->id }}" class="btn btn-danger">Reject</button>
            </td>
          </tr>
        @endif
      @endforeach
      @endif
    </tbody>
  </table>
</form>

<!-- Verified Users Table -->
<h2>Existing Users</h2>
<form class="table-responsive table-wrapper" id="admin-table">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Lastname</th>
        <th>Firstname</th>        
        <th>Email</th>
        <th>Role</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <tbody>
        <!-- If empty this message will display -->
        @if (\App\Models\User::count() === 0)
        <tr>
          <td colspan="6"><strong>No verified users inside the table</strong></td>
        </tr>
        @else      
      @foreach ($users as $user)
        @if ($user->verified == '1')
          <tr>
            <td>{{ $user->id }}</td> 
            <td>{{ $user->lastname }}</td>
            <td>{{ $user->firstname }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->role }}</td>
            <td><a type="submit" class="btn btn-primary" href="{{ 'adminedit/' . $user->id }}">Edit</a></td>
            <td><a type="submit" class="btn btn-danger" href="{{ 'delete/' . $user->id }}">Delete</a></td>
          </tr>
        @endif
      @endforeach
      @endif
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




