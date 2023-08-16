@extends('layout.adminnavlayout')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="mb-0">Create College</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('academics.storeCollege') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="collegeName">College Name</label>
                    <input type="text" class="form-control" id="collegeName" name="collegeName" autocomplete="off" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>
</div>
@show
