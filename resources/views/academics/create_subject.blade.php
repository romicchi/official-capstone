@extends('layout.adminnavlayout')

@section('content')
<div class="container">
        <h1>Create Subject</h1>

        <form action="{{ route('academics.storeSubject') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="subjectName">Subject Name</label>
                <input type="text" class="form-control" id="subjectName" name="subjectName" required>
            </div>
            <div class="form-group">
                <label for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id" required>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}">{{ $course->courseName }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
@show