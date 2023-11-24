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
                    <input type="text" class="form-control" id="disciplineName" name="disciplineName" value="{{ $discipline->disciplineName }}" autocomplete="off">
                    @error('disciplineName')
                    <small _ngcontent-irw-c66 class="text-danger">* Discipline Name is required.</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="college_id">College</label>
                    <select class="form-control" id="college_id" name="college_id" required>
                        @foreach($colleges as $col)
                            <option value="{{ $col->id }}" {{ $col->id == $discipline->college_id ? 'selected' : '' }}>{{ $col->collegeName }}</option>
                        @endforeach
                    </select>
                    @error('college_id')
                    <small _ngcontent-irw-c66 class="text-danger">* College is required.</small>
                    @enderror
                </div>
                <div class="d-flex justify-content-center">
                    <button type="submit" class="btn btn-primary m-1">Update Discipline</button>
                    <a href="{{ route('academics.index') }}?activeTab=disciplines" class="btn btn-secondary m-1">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@show
