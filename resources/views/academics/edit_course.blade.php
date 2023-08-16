@extends('layout.adminnavlayout')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="mb-0">Edit Course</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('academics.updateCourse', $course->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="courseName">Course Name</label>
                    <input type="text" class="form-control" id="courseName" name="courseName" value="{{ $course->courseName }}" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="college_id">College</label>
                    <select class="form-control" id="college_id" name="college_id" required>
                        @foreach($colleges as $col)
                            <option value="{{ $col->id }}" {{ $col->id == $course->college_id ? 'selected' : '' }}>{{ $col->collegeName }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary my-3">Update</button>
            </form>
        </div>
    </div>
</div>
@show
