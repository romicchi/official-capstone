@include('layout.homenav')

<!DOCTYPE html>
<html>
<head>
    <title>GENER | Register</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/register.css') }}">
</head>
<body>

<div class="background" style="background-image: url({{ asset('assets/img/Background.png') }}" loading="lazy">
    <div class="container">
        <div class="col">
            <form action="{{ route('register.post') }}" method="post" enctype="multipart/form-data">
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
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                <!-- Success Message -->
                @if(session()->has('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <h1>Register</h1>
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
                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required>
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
                    <label for="role">I am a:</label>
                    <select class="form-control" id="role" name="role">
                        <option disabled selected>Please select your role</option>
                        <option value="1">Student</option>
                        <option value="2">Teacher</option>
                    </select>
                </div>

                <!-- Year Level Dropdown (Initially Hidden) -->
                <div class="form-group" id="yearLevelGroup" style="display: none;">
                    <label for="year_level">Year Level:</label>
                    <select class="form-control" id="year_level" name="year_level">
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
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
                    <label for="id" class="col-form-label">School ID: </label>
                    <div class="col-md-9">
                        <input id="id" type="file" class="form-control @error('id') is-invalid @enderror" name="id" required autofocus>
                        @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" id="signup-button" class="btn btn-primary my-2">Sign Up</button>
                <p><a href="/login">Already have an account?</a></p>
            </form>
        </div>
    </div>
</div>

@include('loader')
<script src="{{ asset('js/loader.js') }}"></script>
<script>
    // JavaScript to Show Year Level Dropdown and Student Number Field
    document.getElementById('role').addEventListener('change', function () {
        const yearLevelGroup = document.getElementById('yearLevelGroup');
        const studentNumberGroup = document.getElementById('studentNumberGroup');
        if (this.value === '1') {
            yearLevelGroup.style.display = 'block';
            studentNumberGroup.style.display = 'block';
        } else {
            yearLevelGroup.style.display = 'none';
            studentNumberGroup.style.display = 'none';
        }
    });

    // JavaScript to Show Loader When Sign Up Button is Clicked
    document.getElementById('signup-button').addEventListener('click', function () {
        // Show the loader
        document.querySelector('.loader-container').style.display = 'block';
    });
</script>

</body>
</html>
