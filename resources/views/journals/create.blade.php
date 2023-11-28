@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Journal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/journal.css') }}">
</head>

@error('content')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('title')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="container card shadow">
    <h2 class="card-header">Create New Entry</h2>
    <form action="{{ route('journals.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="college">College</label>
            <select class="form-control" id="college" name="college_id" required>
                <option value="">Select College</option>
                @foreach ($colleges as $college)
                <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label for="discipline">Discipline</label>
            <select class="form-control" id="discipline" name="discipline_id" required>
                <option value="">Select Discipline</option>
            </select>
        </div>
        <div class="form-group ckeditor-container">
            <label for="content">Content:</label>
            <textarea id="editor" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary my-2">Create</button>
        <a href="{{ route('journals.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script src="{{ asset('js/fetch.js') }}"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'),{
            ckfinder:
            {
                uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
