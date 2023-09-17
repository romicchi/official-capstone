@extends('layout.adminnavlayout')

<link rel="stylesheet" type="text/css" href="{{ asset('css/table.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/usermanage.css') }}">

<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'existing')">Existing Users</button>
  <button class="tablinks" onclick="openTab(event, 'pending')">Pending Users</button>
  <button class="tablinks" onclick="openTab(event, 'archive')">Archive Viewable</button>
</div>

<!-- Pending Users Tab -->
<div id="pending" class="tabcontent">

<div class="d-flex justify-content-between align-items-center">
<div class="d-flex align-items-center">
    <!-- Role Filter Dropdown -->
    <form class="form-inline" type="GET" action="{{ route('filterPendingByRole') }}">
        <div class="input-group mx-3" style="max-width: 250px;">
            <select class="form-control rounded-0" name="role">
                <option value="all">All Roles</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->role }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary rounded-0" type="submit" id="filter-btn">Filter</button>
            </div>
        </div>
    </form>

    <!-- Sorting Links -->
    <div class="ml-auto px-5">
      <span>Sort By:</span>
      <a href="{{ route('usermanage', ['sort_order' => 'asc']) }}" class="btn btn-link ">Name A-Z</a> |
      <a href="{{ route('usermanage', ['sort_order' => 'desc']) }}" class="btn btn-link">Name Z-A</a>
    </div>
</div>
</div>
@if ($pendingUsers->count() > 0)

  <!-- Unverified Users Table -->
  <form class="table-wrapper" id="admin-table" method="post" action="{{ route('verify-users.post') }}">
    @csrf
    <div class="card shadow mb-4">
    <div class="card-body">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Student Number</th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Email</th>
          <th>Role</th>
          <th>Uploaded ID</th>
          <th>Verified</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- If empty this message will display -->
        @if ($pendingUsers->isEmpty())
          <tr>
            <td colspan="8"><strong>No unverified users inside the table</strong></td>
          </tr>
        @else
          @foreach ($pendingUsers as $user)
          @if ($user->role->role !== 'admin' && $user->role->role !== 'super-admin')
            <tr>
              <td><strong>{{ $user->student_number }}</strong></td>
              <td><strong>{{ $user->lastname }}</strong></td>
              <td><strong>{{ $user->firstname }}</strong></td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->role->role }}</td>
              <td>
                  <!-- Clickable preview image -->
                  <img src="{{ $user->url }}" alt="Uploaded ID" height="50" width="50" class="clickable-preview" onclick="showImage('{{ $user->url }}')">
              </td>
              <td>
                @if ($user->Verified == 1)
                  <span class="badge badge-success badge-lg" style="color: green;">Approved</span>
                @else
                  <span class="badge badge-warning badge-lg" style="color: red;">Pending</span>
                @endif
              </td>
              <td>
                <button type="submit" name="verified_users[]" value="{{ $user->id }}" class="btn btn-primary">Approve</button>
                <button type="submit" name="rejected_users[]" value="{{ $user->id }}" class="btn btn-danger">Reject</button>
              </td>
            </tr>
            @endif
          @endforeach
        @endif
      </tbody>
    </table>
    <!-- Pagination links for Pending Users -->
    <div class="d-flex justify-content-center">
      {{ $pendingUsers->links('pagination::bootstrap-4') }}
    </div>
  </div>
</div>
  </form>

@else
<div class="card shadow mb-4">
  <div class="card-body">
<table class="table table-bordered table-hover" width="100%" cellspacing="0">
  <thead>
    <tr>
      <th>Student Number</th>
      <th>Lastname</th>
      <th>Firstname</th>
      <th>Email</th>
      <th>Role</th>
      <th>Uploaded ID</th>
      <th>Verified</th>
      <th>Approve</th>
      <th>Reject</th>
    </tr>
  </thead>
  <tbody>
  </tbody>
</table>
<center>
    <p>No pending users inside the table</p>
</center>
@endif
</div>
</div>
</div>

<div id="existing" class="tabcontent">

<div class="d-flex justify-content-between align-items-center">
<div class="d-flex align-items-center">
  <!-- Add User Button -->
  <a href="{{ route('adminadd') }}" class="btn btn-success mb-3">+Add User</a>

<!-- Role Filter Dropdown -->
<form class="form-inline" type="GET" action="{{ route('filterByRole') }}">
  <div class="input-group mx-3" style="max-width: 250px;">
    <select class="form-control rounded-0" name="role">
      <option value="all">All Roles</option>
      @foreach($roles as $role)
        <option value="{{ $role->id }}">{{ $role->role }}</option>
      @endforeach
    </select>
    <div class="input-group-append">
      <button class="btn btn-primary rounded-0" type="submit" id="filter-btn">Filter</button>
    </div>
  </div>
</form>
</div>

    <!-- Sorting Links -->
    <div class="ml-auto">
      <span>Sort By:</span>
      <a href="{{ route('usermanage', ['sort_order' => 'asc']) }}" class="btn btn-link ">Name A-Z</a> |
      <a href="{{ route('usermanage', ['sort_order' => 'desc']) }}" class="btn btn-link">Name Z-A</a>
    </div>

  <!-- Search Bar -->
  <form class="form-inline" type="GET" action="{{ route('search') }}">
    <div class="input-group" style="max-width: 250px;">
      <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn" autocomplete="off">
      <div class="input-group-append">
        <button class="btn btn-primary rounded-0" type="submit" id="search-btn">Search</button>
      </div>
    </div>
  </form>
</div>

@if ($existingUsers->count() > 0)
    <!-- Verified Users Table -->
    <div class="card shadow mb-4">
    <div class="card-body">
    <form class="table-wrapper" id="admin-table">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Expiry Date</th>
                    <th>Uploaded ID</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
              @foreach ($existingUsers as $user)
              @if ($user->role->role !== 'admin' && $user->role->role !== 'super-admin')
                    <tr>
                        <td><strong>
                          @if ($user->student_number)
                          {{ $user->student_number }}
                          @else
                          Not Applicable
                          @endif
                        </strong></td>
                        <td><strong>{{ $user->lastname }}</strong></td>
                        <td><strong>{{ $user->firstname }}</strong></td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role->role }}</td>
                        <td>
                            @if ($user->expiration_date)
                                {{ $user->expiration_date }}
                            @else
                                Not Applicable
                            @endif
                    </td>
                        <td>
                            <a href="javascript:void(0);" onclick="showImage('{{ asset($user->url) }}');">
                                <img src="{{ asset($user->url) }}" alt="Uploaded ID" height="50">
                            </a>
                        </td>
                        <td>
                        <a type="submit" class="btn btn-primary" href="{{ route('adminedit', ['id' => $user->id]) }}">Edit</a>
                        <a type="submit" class="btn btn-secondary" href="{{ route('archive', ['id' => $user->id]) }}">Archive</a>
                        <a type="submit" class="btn btn-danger" href="{{ route('delete', ['id' => $user->id]) }}">Delete</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        <!-- Pagination links for Existing Users -->
        <div class="d-flex justify-content-center">
            {{ $existingUsers->links('pagination::bootstrap-4') }}
        </div>
    </form>
</div>
</div>
@else
<div class="card shadow mb-4">
  <div class="card-body">
    <table class="table table-bordered table-hover" width="100%" cellspacing="0">
      <thead>
        <tr>
          <th>Student Number</th>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Email</th>
          <th>Role</th>
          <th>Uploaded ID</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td class="center" colspan="6"><strong>No users found</strong></td>
        </tr>
      </tbody>
    </table>
    @endif
  </div>
</div>
</div>

<div id="archive" class="tabcontent">

<div class="d-flex justify-content-end align-items-center">
<div class="d-flex align-items-center">

<!-- Search Bar for Archive Tab -->
<form class="form-inline" type="GET" action="{{ route('searchArchive') }}">
    <div class="input-group" style="max-width: 250px;">
        <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn" autocomplete="off">
        <div class="input-group-append">
            <button class="btn btn-primary rounded-0" type="submit" id="search-btn">Search</button>
        </div>
    </div>
</form>

</div>
</div>
    <!-- Archive Viewable Users Table -->
    @if ($archiveViewableUsers->count() > 0)
    <form class="table-wrapper" id="admin-table">
      <div class="card shadow mb-4">
      <div class="card-body">
        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Email</th>
                    <th>Role</th> <!-- New column for Role -->
                    <th>Uploaded ID</th> <!-- New column for Uploaded ID -->
                    <th>Year Level</th> <!-- New column for Year Level -->
                    <th>Archived At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($archiveViewableUsers as $user)
                <tr>
                    <td><strong>{{ $user->student_number }}</strong></td>
                    <td><strong>{{ $user->lastname }}</strong></td>
                    <td><strong>{{ $user->firstname }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->role }}</td> <!-- Display Role -->
                    <td>
                        <!-- Display Uploaded ID with a clickable preview -->
                        <a href="javascript:void(0);" onclick="showImage('{{ asset($user->url) }}');">
                            <img src="{{ asset($user->url) }}" alt="Uploaded ID" height="50">
                        </a>
                    </td>
                    <td>{{ $user->year_level }}</td> <!-- Display Year Level -->
                    <td>{{ $user->archived_at }}</td>
                    <td>
                        <!-- Add Reactivate and Delete buttons -->
                        <a type="submit" class="btn btn-success" href="{{ route('reactivate', ['id' => $user->id]) }}">Reactivate</a>
                        <a type="submit" class="btn btn-danger" href="{{ route('delete-archive', ['id' => $user->id]) }}">Delete</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <!-- Pagination links for Archived Viewable Users -->
        <div class="d-flex justify-content-center">
            {{ $archiveViewableUsers->links('pagination::bootstrap-4') }}
        </div>
      </div>
    </div>
    </form>
    @else
    <div class="card shadow mb-4">
        <div class="card-body">
            <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Uploaded ID</th>
                        <th>Year Level</th>
                        <th>Archived At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="center" colspan="8"><strong>No archived users found</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>



<script>
  function showImage(url) {
    // Create an overlay
    var overlay = document.createElement("div");
    overlay.className = "overlay";
    
    // Create an image element
    var image = document.createElement("img");
    image.src = url;
    image.alt = "Uploaded ID";
    image.className = "overlay-image";
    
    // Append the image to the overlay
    overlay.appendChild(image);
    
    // Append the overlay to the body
    document.body.appendChild(overlay);
    
    // Add a click event listener to close the overlay when clicked
    overlay.addEventListener("click", function() {
      document.body.removeChild(overlay);
    });
  }

  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }

</script>
