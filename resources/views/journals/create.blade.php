@extends('layout.usernav')

<script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
<link rel="stylesheet" type="text/css" href="{{ asset('css/journal.css') }}">

@error('content')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('title')
<div class="alert alert-danger">{{ $message }}</div>
@enderror


<div class="container card">
    <h2 class="card-header">Create New Journal</h2>
    <form action="{{ route('journals.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group ckeditor-container">
            <label for="content">Content:</label>
            <textarea id="editor" name="content"></textarea>
        </div>
        <button type="submit" class="btn btn-primary my-2">Create</button>
        <a href="{{ route('journals.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>
<script>
    ClassicEditor
        .create(document.querySelector('#editor'),
        {
            ckfinder:
            {
                uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
