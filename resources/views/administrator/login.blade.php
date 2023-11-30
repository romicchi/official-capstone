<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super-Admin Login</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/admin1.css')}}">
    <style>
        /* Custom CSS styles */
        body {
            background-color: #f5f5f5;
        }
        .overlay {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 50vh;
        }
        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
    </style>
</head>
<body>
    @extends('layout.adminnavlayout')

    <div class="container mt-5">

        @if(session()->has('success'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-success">{{session('success')}}</div>
            </div>
        </div>
        @endif

        <div class="overlay">
            <div class="login-form shadow">
                <h2 class="mb-4">Super-Admin Access</h2>
                @if(session()->has('error'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">{{session('error')}}</div>
            </div>
        </div>
        @endif
                <form class="form-style" action="{{ route('administrator.login.submit') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" autocomplete="off">
                        @error('email')
                        <small _ngcontent-irw-c66 class="text-danger">* Email is required.</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control">
                        @error('password')
                        <small _ngcontent-irw-c66 class="text-danger">* Password is required.</small>
                        @enderror
                    </div>
                    <button type="submit" id="super-login-button" class="btn btn-primary my-3">Login</button>
                </form>
            </div>
        </div>
    </div>

@include('loader')
<script>
    document.getElementById('super-login-button').addEventListener('click', function (event) {
        const email = document.querySelector('input[name="email"]').value;
        const password = document.querySelector('input[name="password"]').value;
        
        if (email.trim() !== '' && password.trim() !== '') {
            event.preventDefault(); // Prevent the form submission
            // Show the loader and change the button text
            document.querySelector('.loader-container').style.display = 'block';
            this.disabled = true; // Disable the button
            this.innerHTML = this.getAttribute('data-loading-text'); // Change button text
            document.querySelector('form').submit(); // Submit the form
        }
    });
</script>

</body>
</html>
    