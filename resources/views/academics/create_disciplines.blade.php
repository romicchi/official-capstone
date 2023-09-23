@extends('layout.adminnavlayout')

@section('content')
<div class="container">
    <div class="card mt-4">
        <div class="card-header">
            <h1 class="mb-0">Create Discipline</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('academics.storeDiscipline') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="discipline_Name">Discipline Name</label>
                    <input type="text" class="form-control" id="discipline_Name" name="name" autocomplete="off" required>
                </div>
                <!-- You can add other fields for discipline information if needed -->

                <button type="submit" class="btn btn-primary my-3">Create Discipline</button>
                <a href="{{ route('academics.index') }}?activeTab=disciplines" class="btn btn-secondary m-1">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection