@extends('layout.usernav')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Update Profile Information') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('update-profile') }}">
                        @csrf

                        @if(session('profile_success'))
                        <div class="alert alert-success">{{ session('profile_success') }}</div>
                        @endif

                        <div class="form-group row">
                            <label for="firstname" class="col-md-4 col-form-label text-md-right">{{ __('Firstname') }}</label>
                            
                            <div class="col-md-6">
                                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname', auth()->user()->firstname) }}" required autocomplete="firstname" autofocus>
                                
                                @error('firstname')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row my-2">
                        <label for="lastname" class="col-md-4 col-form-label text-md-right">{{ __('Lastname') }}</label>
                        
                        <div class="col-md-6">
                            <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname', auth()->user()->lastname) }}" required autocomplete="lastname" autofocus>
                            
                            @error('lastname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', auth()->user()->email) }}" required autocomplete="email">

                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0 my-2">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save Changes') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Change Password') }}</div>
                
                <div class="card-body">
                    <form method="POST" action="{{ route('changePassword') }}">
                        @csrf
                        
                        @if(session('password_success'))
                        <div class="alert alert-success">{{ session('password_success') }}</div>
                        @endif 
                        
                        @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                        @endif
                        <div class="form-group row">
                            <label for="current_password" class="col-md-4 col-form-label text-md-right">{{ __('Current Password') }}</label>
                            <div class="col-md-6">
                                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required autocomplete="current-password">
                                @error('current_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row my-2">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('New Password') }}</label>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirm New Password') }}</label>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0 my-2">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">{{ __('Save Changes') }}</button>
                            </div>
                        </div>
                                