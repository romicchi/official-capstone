@extends('layout.adminnavlayout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 center">
            <div class="card mt-4">
                <div class="card-header">
                    <h1 class="mb-0">Create Course</h1>
                </div>
                <div class="card-body">
                    <form action="{{ route('academics.storeCourse') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="courseName">Course Name</label>
                            <input type="text" class="form-control" id="courseName" name="courseName" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="college_id">College</label>
                            <select class="form-control" id="college_id" name="college_id" required>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary my-3">Create</button>
                        <a href="{{ route('academics.index') }}?activeTab=courses" class="btn btn-secondary m-1">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@show
