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
                <a href="javascript:void(0);" onclick="showImage('{{ asset($user->url) }}');">
                  <img src="{{ asset($user->url) }}" alt="Uploaded ID" height="50">
                </a>
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
                <a href="javascript:void(0);" onclick="showImage('{{ asset($user->url) }}');">
                  <img src="{{ asset($user->url) }}" alt="Uploaded ID" height="50">
                </a>
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

<div class="overlay" id="image-overlay" onclick="closeImage()">
  <img src="" alt="Uploaded ID" id="overlay-image">
</div>

<!-- JavaScript functions -->
<script>
  window.addEventListener('DOMContentLoaded', function() {
    var overlay = document.getElementById("image-overlay");
    var image = document.getElementById("overlay-image");
    overlay.style.display = "none"; // Hide the overlay initially
    image.src = ""; // Set the initial image source to an empty string
  });

  function showImage(url) {
    var overlay = document.getElementById("image-overlay");
    var image = document.getElementById("overlay-image");
    image.src = url;
    overlay.style.display = "flex";
  }

  function closeImage() {
    var overlay = document.getElementById("image-overlay");
    overlay.style.display = "none";
  }
</script>
