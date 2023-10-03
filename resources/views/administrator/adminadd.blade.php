@extends('layout.adminnavlayout')

<title>Add User</title>
<link rel="stylesheet" type="text/css" href="{{ asset ('css/register.css') }}">

<div class="container">
  <div class="col">
        <form class="bg-light" action="{{ route('add.user') }}" method="post" enctype="multipart/form-data">
            @csrf

            <!-- Error Message -->
            @if($errors->any())
            <div class="col-12">
                @foreach($errors->all() as $error)
                <div class="alert alert-danger">{{ $error }}</div>
                @endforeach
            </div>
            @endif

            <!-- Session Error -->
            @if(session()->has('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
            @endif

            <!-- Success Message -->
            @if(session()->has('success'))
            <div class="alert alert-success">{{session('success')}}</div>
            @endif

            <h1>Add User</h1>
            <div class="form-group">
                <label for="firstname">Firstname:</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter Firstname" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="lastname">Lastname:</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Lastname" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm Password:</label>
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password" required>
            </div>
            <div class="form-group">
                <label for="role">Role of the user:</label>
                <select class="form-control" id="role" name="role">
                    <option disabled selected>Select Role</option>
                    <option value="1">Student</option>
                    <option value="2">Teacher</option>
                    <option value="3">Admin</option>
                </select>
            </div>
            <div class="form-group" id="yearLevelContainer" style="display: none;">
                <label for="year_level">Year Level:</label>
                <select class="form-control" id="year_level" name="year_level">
                    <option value="1">1st year</option>
                    <option value="2">2nd year</option>
                    <option value="3">3rd year</option>
                    <option value="4">4th year</option>
                </select>
            </div>

            <div class="form-group" id="studentNumberGroup" style="display: none;">
                <label for="student_number">Student Number:</label>
                <input type="text" class="form-control" id="student_number" name="student_number" placeholder="Enter Student Number" maxlength="7">
            </div>

            <!-- User select college where they belong -->
            <div class="form-group">
                <label for="college_id">College:</label>
                <select class="form-control" id="college_id" name="college_id">
                    <option disabled selected>Please select your college</option>
                    @foreach($colleges as $college)
                    <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group row">
                <label for="id" class="col-form-label">School ID:</label>
                <div class="col-md-9">
                    <input id="id" type="file" class="form-control @error('id') is-invalid @enderror" name="id" required autofocus>
                    @error('file')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="btn btn-primary my-2">Add User</button>
            <a href="{{route('usermanage')}}?activeTab=existing" class="btn btn-danger" style="flex: 1;">Cancel</a>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
