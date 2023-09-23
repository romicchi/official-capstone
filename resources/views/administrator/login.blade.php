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
        @if($errors->any())
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        @endif

        @if(session()->has('error'))
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger">{{session('error')}}</div>
            </div>
        </div>
        @endif

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
                <form action="{{ route('administrator.login.submit') }}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                    <button type="submit" id="login-button" class="btn btn-primary my-3">Login</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

@include('loader')
<script src="{{ asset('js/loader.js') }}"></script>

<script>

</script>
