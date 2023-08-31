@extends('layout.adminnavlayout')

@section('content')
<div class="container mt-5">
    <div class="col-lg-6 mx-auto p-5 border rounded bg-light">
        <div class="card-header">
            <h1 class="mb-0">Edit Subject</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('academics.updateSubject', $subject->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="subjectName">Subject Name</label>
                    <input type="text" class="form-control" id="subjectName" name="subjectName" value="{{ $subject->subjectName }}" autocomplete="off" required>
                </div>
                <div class="form-group">
                    <label for="course_id">Course</label>
                    <select class="form-control" id="course_id" name="course_id" required>
                        @foreach($courses as $crs)
                            <option value="{{ $crs->id }}" {{ $crs->id == $subject->course_id ? 'selected' : '' }}>{{ $crs->courseName }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary m-1">Update</button>
                    <a href="{{ route('academics.index') }}?activeTab=subjects" class="btn btn-secondary m-1">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@show
