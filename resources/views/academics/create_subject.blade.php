@extends('layout.adminnavlayout')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="mb-0">Create Subject</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('academics.storeSubject') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="subjectName">Subject Name</label>
                    <input type="text" class="form-control" id="subjectName" name="subjectName" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="course_id">Course</label>
                    <select class="form-control" id="course_id" name="course_id" required>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->courseName }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary my-3">Create</button>
                <a href="{{ route('academics.index') }}?activeTab=subjects" class="btn btn-secondary m-1">Cancel</a>
            </form>
        </div>
    </div>
</div>
@show