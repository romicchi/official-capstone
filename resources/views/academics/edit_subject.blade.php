@extends('layout.adminnavlayout')

@section('content')

<div class="container">
        <h1>Edit Subject</h1>

        <form action="{{ route('academics.updateSubject', $subject->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="subjectName">Subject Name</label>
                <input type="text" class="form-control" id="subjectName" name="subjectName" value="{{ $subject->subjectName }}" required>
            </div>
            <div class="form-group">
                <label for="course_id">Course</label>
                <select class="form-control" id="course_id" name="course_id" required>
                    @foreach($courses as $crs)
                        <option value="{{ $crs->id }}" {{ $crs->id == $subject->course_id ? 'selected' : '' }}>{{ $crs->courseName }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>

@show