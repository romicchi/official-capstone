
@extends('layout.adminnavlayout')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="mb-0">Edit College</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('academics.updateCollege', $college->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="collegeName">College Name</label>
                    <input type="text" class="form-control" id="collegeName" name="collegeName" value="{{ $college->collegeName }}" autocomplete="off" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@show