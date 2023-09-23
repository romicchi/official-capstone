@extends('layout.adminnavlayout')

@section('content')
<div class="container mt-5">
    @if(session()->has('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session()->has('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="container">
        <div class="card shadow">
            <div class="card-header">
                <h2>Backup</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('administrator.backup') }}" method="post">
                    @csrf
                    <button type="submit" id="backup-button" class="btn btn-primary">Backup</button>
                </form>
            </div>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header">
                <h2>Restore Backup</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('administrator.restore') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="backup_file">Select Backup ZIP/Sql File:</label>
                        <input type="file" class="form-control" id="backup_file" name="backup_file">
                    </div>
                    <button type="submit" id="restore-button" class="btn btn-primary my-3">Restore</button>
                </form>
            </div>
        </div>
    </div>
</div>
@show

@include('loader')
<script src="{{ asset('js/loader.js') }}"></script>

<script>
// JavaScript to Show Loader When Login Button is Clicked
document.getElementById('backup-button').addEventListener('click', function () {
    // Show the loader
    document.querySelector('.loader-container').style.display = 'block';
});

// JavaScript to Show Loader When Login Button is Clicked
document.getElementById('restore-button').addEventListener('click', function () {
    // Show the loader
    document.querySelector('.loader-container').style.display = 'block';
});
</script>