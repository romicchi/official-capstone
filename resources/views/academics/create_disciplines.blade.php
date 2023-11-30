@extends('layout.adminnavlayout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 center">
            <div class="card mt-4">
                <div class="card-header">
                    <h1 class="mb-0">Create Discipline</h1>
                </div>
                <div class="card-body">
                    <form class="form-style" action="{{ route('academics.storeDiscipline') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="discipline_Name">Discipline Name</label>
                            <input type="text" class="form-control" id="discipline_Name" name="discipline_Name" autocomplete="off" value="{{ old('discipline_Name') }}">
                            @error('discipline_Name')
                            <small _ngcontent-irw-c66 class="text-danger">* Discipline is required.</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="college_id">College</label>
                            <select class="form-control" id="college_id" name="college_id" required>
                                <option disabled selected>Select College</option>
                                @foreach($colleges as $college)
                                    <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                                @endforeach
                            </select>
                            @error('college_id')
                            <small _ngcontent-irw-c66 class="text-danger">* College is required.</small>
                            @enderror
                        </div>
                        <button type="submit" class="btn btn-primary my-3">Create Discipline</button>
                        <a href="{{ route('academics.index') }}?activeTab=disciplines" class="btn btn-secondary">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@show