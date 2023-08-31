@extends('layout.adminnavlayout')

<link rel="stylesheet" type="text/css" href="{{ asset('css/table.css') }}">

<style>
  /* Style for the overlay */
  .overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5); /* Adjust the opacity as needed */
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
    backdrop-filter: blur(5px); /* Apply the blur effect */
  }

  /* Style for the image */
  .overlay img {
    max-width: 80%;
    max-height: 80%;
    border: 2px solid #fff;
    border-radius: 5px;
  }
</style>

@if ($pendingUsers->count() > 0)
  <!-- Search Bar -->
  <div class="d-flex justify-content-end my-1">
    <form class="form-inline" type="GET" action="{{ route('search') }}">
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
  <form class="table-wrapper" id="admin-table" method="post" action="{{ route('verify-users.post') }}">
    @csrf
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
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
        <!-- If empty this message will display -->
        @if ($pendingUsers->isEmpty())
          <tr>
            <td colspan="8"><strong>No unverified users inside the table</strong></td>
          </tr>
        @else
          @foreach ($pendingUsers as $user)
            <tr>
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
              </td>
              <td>
                <button type="submit" name="rejected_users[]" value="{{ $user->id }}" class="btn btn-danger">Reject</button>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <!-- Pagination links for Pending Users -->
    <div class="d-flex justify-content-center">
      {{ $pendingUsers->links('pagination::bootstrap-4') }}
    </div>
  </form>

@else
  <div class="d-flex justify-content-end my-1">
    <form class="form-inline" type="GET" action="{{ route('search') }}">
      <div class="input-group" style="max-width: 250px;">
        <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn">
        <button class="btn btn-success rounded-0" type="submit" id="search-btn">Search</button>
      </div>
    </form>
  </div>
  <a href="{{ route('adminadd') }}" class="btn btn-primary">ADD USER</a>
  <p>No users found</p>
@endif

@if ($existingUsers->count() > 0)
  <!-- Verified Users Table -->
  <h2>Existing Users</h2>
  <form class="table-wrapper" id="admin-table">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>Lastname</th>
          <th>Firstname</th>
          <th>Email</th>
          <th>Role</th>
          <th>Uploaded ID</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- If empty this message will display -->
        @if ($existingUsers->isEmpty())
          <tr>
            <td colspan="6"><strong>No verified users inside the table</strong></td>
          </tr>
        @else
          @foreach ($existingUsers as $user)
            <tr>
              <td><strong>{{ $user->lastname }}</strong></td>
              <td><strong>{{ $user->firstname }}</strong></td>
              <td>{{ $user->email }}</td>
              <td>{{ $user->role->role }}</td>
              <td>
                  <!-- Clickable preview image -->
                  <img src="{{ $user->url }}" alt="Uploaded ID" height="50" width="50" class="clickable-preview" onclick="showImage('{{ $user->url }}')">
              </td>
              <td>
                <a type="submit" class="btn btn-primary" href="{{ 'adminedit/' . $user->id }}">Edit</a>
                <a type="submit" class="btn btn-danger" href="{{ 'delete/' . $user->id }}">Delete</a>
              </td>
            </tr>
          @endforeach
        @endif
      </tbody>
    </table>
    <!-- Pagination links for Existing Users -->
    <div class="d-flex justify-content-center">
      {{ $existingUsers->links('pagination::bootstrap-4') }}
    </div>
  </form>
@endif

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
</script>
