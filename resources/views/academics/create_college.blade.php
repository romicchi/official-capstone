@extends('layout.adminnavlayout')

@section('content')
<div class="container">
        <h1>Create College</h1>

        <form action="{{ route('academics.storeCollege') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="collegeName">College Name</label>
                <input type="text" class="form-control" id="collegeName" name="collegeName" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@show