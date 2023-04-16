@extends('dashboard')
@include('layout.forumlayout')

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forum</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
    <!-- <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('')}}"> -->
    <!-- @yield('css') -->
</head>
<body>

<!-- This will display the Channels in the Providers/AppServiceProvider -->
@auth
<main class="container py-4">
    <div class="row">
        <!-- Channels -->
        <!-- Yield will add the Channels as well as the Add Discussion Button in the layout -->
        @yield('Channel-Add')
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    Welcome to Forum
                </div>
            </div>
        </div>
    </div>
</main>

@endauth

<!-- @yield('js') -->
</body>
</html>