@extends('layout.adminnavlayout')

@section('content')
<div class="container mt-5">
    <div class="col-lg-6 mx-auto p-5 border rounded bg-light">
        <div class="card-header">
            <h1 class="mb-0">Edit Discipline</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('academics.updateDiscipline', $discipline->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="disciplineName">Discipline Name</label>
                    <input type="text" class="form-control" id="disciplineName" name="name" value="{{ $discipline->name }}" autocomplete="off" required>
                </div>
                <!-- You can add other fields for discipline information if needed -->

                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary m-1">Update Discipline</button>
                    <a href="{{ route('academics.index') }}?activeTab=disciplines" class="btn btn-secondary m-1">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
