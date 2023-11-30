@extends('layout.adminnavlayout')

<title>Add User</title>
<link rel="stylesheet" type="text/css" href="{{ asset ('css/register.css') }}">

<div class="container">
  <div class="col">
        <form class="bg-light form-style" action="{{ route('add.user') }}" method="post" enctype="multipart/form-data">
            @csrf

            <h1>Add User</h1>
                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="firstname" class="col-form-label">Firstname:</label>
                        <input type="text" class="form-control" maxlength="50" id="firstname" name="firstname" placeholder="Enter Firstname" autocomplete="off" value="{{ old('firstname') }}">
                        @error('firstname')
                        <small _ngcontent-irw-c66 class="text-danger">* Firstname is required.</small>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label for="lastname" class="col-form-label">Lastname:</label>
                        <input type="text" class="form-control" maxlength="50" id="lastname" name="lastname" placeholder="Enter Lastname" autocomplete="off" value="{{ old('lastname') }}">
                        @error('lastname')
                        <small _ngcontent-irw-c66 class="text-danger">* Lastname is required.</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="suffix" class="col-form-label">Suffix:</label>
                        <input type="text" class="form-control" maxlength="10" id="suffix" name="suffix" placeholder="(ex. Jr.)" value="{{ old('suffix') }}">
                        @error('suffix')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="email" class="col-form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" autocomplete="off" value="{{ old('email') }}">
                    @error('email')
                    <small _ngcontent-irw-c66 class="text-danger">* {{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="role" class="col-form-label">Role of the user:</label>
                    <select class="form-control" id="role" name="role">
                        <option disabled selected>Select Role</option>
                        <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Student</option>
                        <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Teacher</option>
                        <option value="3">Admin</option>
                    </select>
                    @error('role')
                    <small _ngcontent-irw-c66 class="text-danger">* Role is required.</small>
                    @enderror   
                </div>
            </div>

            <div class="form-group row">
            <div class="col-md-6">
            <div id="yearLevelContainer" style="display: none;">
                <label for="year_level" class="col-form-label">Year Level:</label>
                <select class="form-control" id="year_level" name="year_level">
                    <option value="1">1st year</option>
                    <option value="2">2nd year</option>
                    <option value="3">3rd year</option>
                    <option value="4">4th year</option>
                </select>
                @error('year_level')
                <small _ngcontent-irw-c66 class="text-danger">* Year Level is required.</small>
                @enderror
            </div>
            </div>

            <div class="col-md-6" id="studentNumberGroup" style="display: none;">
                <label for="student_number" class="col-form-label">Student Number:</label>
                <input type="text" class="form-control" id="student_number" name="student_number" placeholder="Enter Student Number" maxlength="7">
                @error('student_number')
                <small _ngcontent-irw-c66 class="text-danger">* Student Number is required.</small>
                @enderror
            </div>
            </div>

            <!-- User select college where they belong -->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="college_id" class="col-form-label">College:</label>
                    <select class="form-control" id="college_id" name="college_id">
                        <option disabled selected>Please select your college</option>
                        @foreach($colleges as $college)
                        <option value="{{ $college->id }}" {{ old('college_id') == $college->id ? 'selected' : '' }}>{{ $college->collegeName }}</option>
                        @endforeach
                    </select>
                    @error('college_id')
                    <small _ngcontent-irw-c66 class="text-danger">* College is required.</small>
                    @enderror
                </div>

                <div class="col-md-6">                
                    <label for="id" class="col-form-label">School ID:</label>
                        <input id="id" type="file" accept="image/*" class="form-control @error('id') is-invalid @enderror" name="id" autofocus>
                        @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @error('id')
                        <small _ngcontent-irw-c66 class="text-danger">* ID is required.</small>
                        @enderror
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="password" class="col-form-label">Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                        <span class="input-group-text">
                            <i class="fas fa-eye" id="togglePassword"></i>
                        </span>
                    </div>
                    @error('password')
                    <small _ngcontent-irw-c66 class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation" class="col-form-label">Confirm Password:</label>
                    <div class="input-group">
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                        <span class="input-group-text">
                            <i class="fas fa-eye" id="toggleConfirmationPassword"></i>
                        </span>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-primary my-2">Add User</button>
            <a href="{{route('usermanage')}}?activeTab=existing" class="btn btn-danger" style="flex: 1;">Cancel</a>
        </form>
    </div>
</div>

<script src="{{ asset('js/admin.js') }}"></script>
<script src="{{ asset('js/togglepass.js') }}"></script>
