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

      @if(auth()->user()->role_id == 4)
      <div class="form-group">
        <label for="password">Password:</label>
        <input class="form-control rounded-0" type="text" id="password" name="password" value="{{ $users->password }}" required>
      </div>
      @endif
      
      <div class="form-group">
        <label for="role">Role of the user:</label>
        <select class="form-control" id="role" name="role">
          <option value="1" {{ $users->role_id == 1 ? 'selected' : '' }}>Student</option>
          <option value="2" {{ $users->role_id == 2 ? 'selected' : '' }}>Teacher</option>
          <option value="3" {{ $users->role_id == 3 ? 'selected' : '' }}>Admin</option>
        </select>
      </div>

      <!-- Display Year Level input when role is "Student" -->
      <div class="form-group" id="yearLevelGroup">
        <label for="year_level">Year Level:</label>
        <select class="form-control" id="year_level" name="year_level">
          <option value="1" {{ $users->year_level == 1 ? 'selected' : '' }}>1st Year</option>
          <option value="2" {{ $users->year_level == 2 ? 'selected' : '' }}>2nd Year</option>
          <option value="3" {{ $users->year_level == 3 ? 'selected' : '' }}>3rd Year</option>
          <option value="4" {{ $users->year_level == 4 ? 'selected' : '' }}>4th Year</option>
        </select>
      </div>

      <!-- Student Number Input (Initially Hidden) -->
      <div class="form-group" id="studentNumberGroup">
        <label for="student_number">Student Number:</label>
        <input class="form-control rounded-0" type="text" id="student_number" name="student_number" value="{{ $users->student_number }}" maxlength="7">
      </div>

      <!-- User select college where they belong -->
      <div class="form-group">
        <label for="college_id">College:</label>
        <select class="form-control" id="college_id" name="college_id">
          <option disabled selected>Please select your college</option>
          @foreach($colleges as $college)
          <option value="{{ $college->id }}" {{ $users->college_id == $college->id ? 'selected' : '' }}>{{ $college->collegeName }}</option>
          @endforeach
        </select>
      
      <div class="d-flex justify-content-center">
        <button type="submit" class="btn btn-primary m-1">Update</button>
        <a href="{{ route('usermanage') }}?activeTab=existing" class="btn btn-secondary m-1">Cancel</a>
      </div>
      
    </form>
  </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>