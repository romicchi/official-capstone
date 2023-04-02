@extends('admin')


<link rel="stylesheet" type="text/css" href="{{ asset ('css/admin.css')}}">

<!-- Search Bar -->
<div class="dropdown">
  <input class="form-control-sm" id="myInput" type="text" placeholder="Search..">
</div>

<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead>
      <tr>
        <th>ID</th>
        <th>Username</th>
        <th>Email</th>
        <th>Password</th>
        <th>Update</th>
        <th>Delete</th>
      </tr>
    </thead>
    <!-- {{-- <tbody>
      @forelse ($items as $item)
        <tr>
          <td>{{ $item->id }}</td>
          <td>{{ $item->username }}</td>
          <td>{{ $item->email }}</td>
          <td>{{ $item->password }}</td>
          <td><a href="{{ route('update', $item->id) }}">Update</a></td>
          <td><a href="{{ route('delete', $item->id) }}">Delete</a></td>
        </tr>
       @empty 
        <tr>
          <td colspan="6">No items found.</td>
        </tr>
       @endforelse 
    </tbody> --}} -->
  </table>
</div>
<!-- your courses content here -->