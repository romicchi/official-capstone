@extends('layout.adminnavlayout')

@section('content')
<div class="container">
        <h1>Create Course</h1>

        <form action="{{ route('academics.storeCourse') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="courseName">Course Name</label>
                <input type="text" class="form-control" id="courseName" name="courseName" required>
            </div>
            <div class="form-group">
                <label for="college_id">College</label>
                <select class="form-control" id="college_id" name="college_id" required>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@show