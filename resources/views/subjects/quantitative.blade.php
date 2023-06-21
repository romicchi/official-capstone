@extends('layout.resourcelayout')


@section('title', 'Quantitative Methods and Simulation')

@if(auth()->user()->role_id == 3)
    @include('layout.adminnavlayout')
    @yield('adminnavbar')
@else
    @include('layout.usernav')
    @yield('usernav')
@endif

@section('resourcelayout')
    @parent
@endsection





































