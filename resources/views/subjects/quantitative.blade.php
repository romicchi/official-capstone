@extends('layout.resourcelayout')


@section('title', 'Quantitative Methods and Simulation')

@if(auth()->user()->role == 'admin')
    @include('layout.adminnavlayout')
    @yield('adminnavbar')
@else
    @include('layout.usernav')
    @yield('usernav')
@endif

@section('resourcelayout')
    @parent
@endsection





































