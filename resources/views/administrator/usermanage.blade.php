@extends('layout.adminnavlayout')

<head>
  <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/usermanage.css') }}">
</head>

<div class="tab">
  <button class="tablinks" onclick="openTab(event, 'existing')">Existing Users</button>
  <button class="tablinks" onclick="openTab(event, 'pending')">Pending Users</button>
  <button class="tablinks" onclick="openTab(event, 'archive')">Archived Users</button>
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
</div>
<!-- Sorting -->
<form class="form-inline" type="GET" action="{{ route('sortPending') }}">
    <div class="input-group mx-3" style="max-width: 250px;">
        <select class="form-control rounded-0" name="sort_order">
            <option value="asc">Name A-Z</option>
            <option value="desc">Name Z-A</option>
        </select>
        <div class="input-group-append">
            <button class="btn btn-primary rounded-0" type="submit" id="sort-btn">Sort</button>
        </div>
    </div>
</form>
  <!-- Search Bar -->
  <form class="form-inline" type="GET" action="{{ route('searchPending') }}">
    <div class="input-group" style="max-width: 250px;">
      <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn" autocomplete="off">
      <div class="input-group-append">
        <button class="btn btn-primary rounded-0" type="submit" id="search-btn">Search</button>
      </div>
    </div>
  </form>
</div>
@if ($pendingUsers->count() > 0)

  <!-- Unverified Users Table -->
  <form class="table-wrapper" id="admin-table" method="post" action="{{ route('verify-users.post') }}">
    @csrf
    <div class="card shadow mb-4">
    <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>Student Number</th>
            <th>Lastname</th>
            <th>Firstname</th>
            <th>Email</th>
            <th>College</th>
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
                <td>{{ $user->college->collegeName }}</td>
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
                  <button type="submit" class="btn approve-button" title="Approve" name="verified_users[]" value="{{ $user->id }}">
                    <i class="fas fa-check p-1"></i>
                  </button>
                  <button type="submit" title="Reject" name="rejected_users[]" value="{{ $user->id }}" class="btn">
                    <i class="fas fa-times p-1"></i>
                  </button>
                </td>
              </tr>
              @endif
            @endforeach
          @endif
        </tbody>
      </table>
    </div>
  </div>
</div>
<!-- Pagination links for Pending Users -->
<div class="d-flex justify-content-center">
  {{ $pendingUsers->links('pagination::bootstrap-4') }}
</div>
  </form>

@else
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Student Number</th>
            <th>Lastname</th>
            <th>Firstname</th>
            <th>Email</th>
            <th>College</th>
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
      </div>
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
  <a href="{{ route('adminadd') }}" class="btn btn-success mb-3 py-2 px-3">
    <i class="fas fa-plus"></i>
  </a>

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

<!-- Sorting -->
<form class="form-inline" type="GET" action="{{ route('sortExisting') }}">
    <div class="input-group mx-3" style="max-width: 250px;">
        <select class="form-control rounded-0" name="sort_order">
            <option value="asc">Name A-Z</option>
            <option value="desc">Name Z-A</option>
        </select>
        <div class="input-group-append">
            <button class="btn btn-primary rounded-0" type="submit" id="sort-btn">Sort</button>
        </div>
    </div>
</form>

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
      <div class="table-responsive">
        <table class="table table-hover" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th>Student Number</th>
                    <th>Lastname</th>
                    <th>Firstname</th>
                    <th>Email</th>
                    <th>College</th>
                    <th>Role</th>
                    <th>Year Level</th>
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
                        <td>{{ $user->college->collegeName }}</td>
                        <td>{{ $user->role->role }}</td>
                        <td>
                          @if ($user->year_level)
                          {{ $user->year_level }}
                          @else
                          Not Applicable
                          @endif
                        </td>
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
                        <a type="submit" class="btn" title="Edit" href="{{ route('adminedit', ['id' => $user->id]) }}">
                          <i class="fas fa-edit p-1"></i>
                        </a>
                        <a type="submit" class="btn archive-button" title="Archive" href="{{ route('archive', ['id' => $user->id]) }}">
                          <i class="fas fa-archive p-1"></i>
                        </a>
                        <a type="submit" class="btn delete-confirm" title="Delete" href="{{ route('delete', ['id' => $user->id]) }}">
                          <i class="fas fa-trash-alt p-1"></i>
                        </a>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
      </div>
    </form>
  </div>
</div>
<!-- Pagination links for Existing Users -->
<div class="d-flex justify-content-center">
    {{ $existingUsers->links('pagination::bootstrap-4') }}
</div>
@else
<div class="card shadow mb-4">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>Student Number</th>
            <th>Lastname</th>
            <th>Firstname</th>
            <th>Email</th>
            <th>College</th>
            <th>Role</th>
            <th>Uploaded ID</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          </tbody>
        </table>
      </div>
      <center>
        <td class="center" colspan="6"><strong>No users found</strong></td>
      </center>
      @endif
    </div>
  </div>
</div>

<div id="archive" class="tabcontent">

<div class="d-flex justify-content-between align-items-center">
<div class="d-flex align-items-center">
    <!-- Role Filter Dropdown -->
    <form class="form-inline" type="GET" action="{{ route('filterArchiveByRole') }}">
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

<!-- Sorting -->
<form class="form-inline" type="GET" action="{{ route('sortArchive') }}">
    <div class="input-group mx-3" style="max-width: 250px;">
        <select class="form-control rounded-0" name="sort_order">
            <option value="asc">Name A-Z</option>
            <option value="desc">Name Z-A</option>
        </select>
        <div class="input-group-append">
            <button class="btn btn-primary rounded-0" type="submit" id="sort-btn">Sort</button>
        </div>
    </div>
</form>

<!-- Search Bar for Archive Tab -->
<form class="form-inline justify-content-end" type="GET" action="{{ route('searchArchive') }}">
    <div class="input-group" style="max-width: 250px;">
        <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn" autocomplete="off">
        <div class="input-group-append">
            <button class="btn btn-primary rounded-0" type="submit" id="search-btn">Search</button>
        </div>
    </div>
</form>
</div>
    <!-- Archive Viewable Users Table -->
    @if ($archiveViewableUsers->count() > 0)
    <form class="table-wrapper" id="admin-table">
      <div class="card shadow mb-4">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-hover" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Student Number</th>
                        <th>Lastname</th>
                        <th>Firstname</th>
                        <th>Email</th>
                        <th>College</th>
                        <th>Role</th>
                        <th>Uploaded ID</th>
                        <th>Year Level</th>
                        <th>Archived At</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($archiveViewableUsers as $user)
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
                        <td>{{ $user->college->collegeName }}</td>
                        <td>{{ $user->role->role }}</td>
                        <td>
                            <!-- Display Uploaded ID with a clickable preview -->
                            <a href="javascript:void(0);" onclick="showImage('{{ asset($user->url) }}');">
                                <img src="{{ asset($user->url) }}" alt="Uploaded ID" height="50">
                            </a>
                        </td>
                        <td>
                          @if ($user->year_level)
                          {{ $user->year_level }}
                          @else
                          Not Applicable
                          @endif
                        </td>
                        <td>{{ $user->archived_at }}</td>
                        <td>
                            <!-- Add Reactivate and Delete buttons -->
                            <a type="submit" id="reactivate-button" title="Reactivate" class="btn" href="{{ route('reactivate', ['id' => $user->id]) }}">
                              <i class="fas fa-undo p-1"></i>
                            </a>
                            <a type="submit" class="btn delete-confirm" title="Delete" href="{{ route('delete-archive', ['id' => $user->id]) }}">
                              <i class="fas fa-trash-alt p-1"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
      </div>
      <!-- Pagination links for Archived Viewable Users -->
      <div class="d-flex justify-content-center">
          {{ $archiveViewableUsers->appends(['activeTab' => 'archive'])->links('pagination::bootstrap-4') }}
      </div>
    </form>
    @else
    <div class="card shadow mb-4">
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Student Number</th>
                <th>Lastname</th>
                <th>Firstname</th>
                <th>Email</th>
                <th>College</th>
                <th>Role</th>
                <th>Uploaded ID</th>
                <th>Year Level</th>
                <th>Archived At</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              </tbody>
            </table>
          </div>
          <center>
            <p>No archived users inside the table</p>
          </center>
        </div>
      </div>
      @endif
    </div>

@include('loader')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script>
// To Show Loader When archive button is clicked
document.querySelectorAll('.archive-button').forEach(function(button) {
    button.addEventListener('click', function () {
        // Show the loader
        document.querySelector('.loader-container').style.display = 'block';
    });
});

// To Show loader when approve button is Clicked
document.querySelectorAll('.approve-button').forEach(function(button) {
    button.addEventListener('click', function () {
        // Show the loader
        document.querySelector('.loader-container').style.display = 'block';
    });
});

// To Show loader when reactivate button is Clicked
document.getElementById('reactivate-button').addEventListener('click', function () {
    // Show the loader
    document.querySelector('.loader-container').style.display = 'block';
});
</script>
