@include('layout.homenav')

<!DOCTYPE html>
<html>
<head>
    <title>GENER | Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/global.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">
</head>
<body>

<div class="background" style="background-image: url({{ asset('assets/img/Background.png') }})" loading="lazy">
    <div class="container">
        <div class="col">
            <form class="bg-light" action="{{ route('register.post') }}" method="post" enctype="multipart/form-data">
                @csrf

                <h2 class="font-poppins-bold">Register</h2>
                <div class="form-group row">
                    <div class="col-md-5">
                        <label for="firstname" class="col-form-label">Firstname:</label>
                        <input type="text" class="form-control" maxlength="50" id="firstname" name="firstname" placeholder="Enter Firstname" autocomplete="off" value="{{ old('firstname') }}">
                        @error('firstname')
                        <small _ngcontent-irw-c66 class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-5">
                        <label for="lastname" class="col-form-label">Lastname:</label>
                        <input type="text" class="form-control" maxlength="50" id="lastname" name="lastname" placeholder="Enter Lastname" autocomplete="off" value="{{ old('lastname') }}">
                        @error('lastname')
                        <small _ngcontent-irw-c66 class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-2">
                        <label for="suffix" class="col-form-label">Suffix:</label>
                        <input type="text" class="form-control" maxlength="10" id="suffix" name="suffix" placeholder="(ex. Jr.)" value="{{ old('suffix') }}">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="email" class="col-form-label">Email:</label>
                        <input type="email" class="form-control" maxlength="50" id="email" name="email" placeholder="Enter Email" value="{{ old('email') }}">
                        @error('email')
                        <small _ngcontent-irw-c66 class="text-danger">* {{ $message }}</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="role" class="col-form-label">I am a:</label>
                        <select class="form-control" id="role" name="role">
                            <option disabled selected>Please select your role</option>
                            <option value="1" {{ old('role') == 1 ? 'selected' : '' }}>Student</option>
                            <option value="2" {{ old('role') == 2 ? 'selected' : '' }}>Teacher</option>
                        </select>
                        @error('role')
                        <small _ngcontent-irw-c66 class="text-danger">* Role is required.</small>
                        @enderror
                    </div>
                </div>

                <!-- Year Level Dropdown (Initially Hidden) -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <div id="yearLevelGroup" style="display: none;">
                            <label for="year_level" class="col-form-label">Year Level:</label>
                            <select class="form-control" id="year_level" name="year_level">
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6" id="studentNumberGroup" style="display: none;">
                        <label for="student_number" class="col-form-label">Student Number:</label>
                        <input type="text" class="form-control" id="student_number" name="student_number" placeholder="Enter Student Number" maxlength="7">
                    </div>
                </div>

                <!-- User select college where they belong -->
                <div class="form-group row">
                    <div class="col-md-6">
                        <label for="college_id" class="col-form-label">College:</label>
                        <select class="form-control" id="college_id" name="college_id">
                            <option disabled selected>Please select your college</option>
                            @foreach($colleges as $college)
                            <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                            @endforeach
                        </select>
                        @error('college_id')
                        <small _ngcontent-irw-c66 class="text-danger">* College is required.</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="id" class="col-form-label">School ID: </label>
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
                            <input type="password" class="form-control" maxlength="100" id="password" name="password" placeholder="Enter Password">
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="togglePassword"></i>
                            </span>
                        </div>
                        @error('password')
                        <small _ngcontent-irw-c66 class="text-danger">* Password is required.</small>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="password_confirmation" class="col-form-label">Confirm Password:</label>
                        <div class="input-group">
                            <input type="password" class="form-control" maxlength="100" id="password_confirmation" name="password_confirmation" placeholder="Confirm Password">
                            <span class="input-group-text">
                                <i class="fas fa-eye" id="toggleConfirmationPassword"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <button type="submit" id="signup-button" class="btn btn-primary my-2">Sign Up</button>
                <p><a href="{{ route('login') }}">Already have an account?</a></p>
            </form>
        </div>
    </div>
</div>

@include('loader')
<script src="{{ asset('js/loader.js') }}"></script>
<script src="{{ asset('js/register.js') }}"></script>
<script src="{{ asset('js/togglepass.js') }}"></script>
</body>
</html>
