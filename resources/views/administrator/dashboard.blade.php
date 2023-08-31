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
        <div class="card">
            <div class="card-header">
                <h2>Backup and Restore Dashboard</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('administrator.backup') }}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-primary">Backup</button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h2>Restore Backup</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('administrator.restore') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="backup_file">Select Backup ZIP File:</label>
                        <input type="file" class="form-control" id="backup_file" name="backup_file">
                    </div>
                    <button type="submit" class="btn btn-primary">Restore</button>
                </form>
            </div>
        </div>
    </div>
</div>
@show
