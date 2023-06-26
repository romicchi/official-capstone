@extends('layout.adminnavlayout')

@section('content')
<div class="container">
        <h1>Edit College</h1>

        <form action="{{ route('academics.updateCollege', $college->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="collegeName">College Name</label>
                <input type="text" class="form-control" id="collegeName" name="collegeName" value="{{ $college->collegeName }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
@show