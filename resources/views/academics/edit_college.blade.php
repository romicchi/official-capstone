
@extends('layout.adminnavlayout')

@section('content')
<div class="container mt-5">
    <div class="col-lg-6 mx-auto p-5 border rounded bg-light">
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
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary m-1">Update</button>
                    <a href="{{ route('academics.index') }}?activeTab=colleges" class="btn btn-secondary m-1">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@show

