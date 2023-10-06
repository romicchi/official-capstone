@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.2/classic/ckeditor.js"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/journal.css') }}">
</head>

@error('title')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('content')
    <div class="alert alert-danger">{{ $message }}</div>
@enderror

<div class="container card shadow">
    <h3>Edit Note</h3>
    <form action="{{ route('journals.update', $journal) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $journal->title }}">
        </div>
        <div class="form-group ckeditor-container">
            <label for="content">Content:</label>
            <textarea id="editor" name="content">{{ $journal->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary my-2">Save</button>
        <a href="{{ route('journals.show', $journal) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    ClassicEditor
        .create(document.querySelector('#editor'), {
            ckfinder: {
                uploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            }
        })
        .catch(error => {
            console.error(error);
        });
</script>
