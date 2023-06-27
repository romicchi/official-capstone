@extends('layout.adminnavlayout')

@section('content')
<div class="container">
        <h1>Edit Course</h1>

        <form action="{{ route('academics.updateCourse', $course->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="courseName">Course Name</label>
                <input type="text" class="form-control" id="courseName" name="courseName" value="{{ $course->courseName }}" required>
            </div>
            <div class="form-group">
                <label for="college_id">College</label>
                <select class="form-control" id="college_id" name="college_id" required>
                    @foreach($colleges as $col)
                        <option value="{{ $col->id }}" {{ $col->id == $course->college_id ? 'selected' : '' }}>{{ $col->collegeName }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

@show