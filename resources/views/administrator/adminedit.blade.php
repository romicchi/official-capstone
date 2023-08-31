@extends('layout.adminnavlayout')

<div class="container mt-5">
  <div class="col-lg-6 mx-auto p-5 border rounded bg-light">
    <form action="{{ route('update') }}" method="POST">
      @csrf
      <h1 class="text-center mb-4">Update User</h1>
      <input type="hidden" name="id" value="{{ $users->id }}">
      
      <div class="form-group">
        <label for="firstname">Firstname:</label>
        <input class="form-control rounded-0" type="text" id="firstname" name="firstname" value="{{ $users->firstname }}" required>
      </div>
      
      <div class="form-group">
        <label for="lastname">Lastname:</label>
        <input class="form-control rounded-0" type="text" id="lastname" name="lastname" value="{{ $users->lastname }}" required>
      </div>
      
      <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control rounded-0" type="email" id="email" name="email" value="{{ $users->email }}" required>
      </div>
      
      <div class="form-group">
        <label for="role">Role of the user:</label>
        <select class="form-control" id="role" name="role">
          <option value="1" {{ $users->role_id == 1 ? 'selected' : '' }}>Student</option>
          <option value="2" {{ $users->role_id == 2 ? 'selected' : '' }}>Teacher</option>
          <option value="3" {{ $users->role_id == 3 ? 'selected' : '' }}>Admin</option>
        </select>
      </div>
      
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary m-1">Update</button>
        <a href="{{ route('usermanage') }}?activeTab=existing" class="btn btn-secondary m-1">Cancel</a>
      </div>
      
    </form>
  </div>
</div>
