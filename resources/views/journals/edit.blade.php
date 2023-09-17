@extends('layout.usernav')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/journal.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.css">
    
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
        <div class="form-group">
        <label for="content">Content:</label>
            <input id="content" type="hidden" name="content" value="{{ $journal->content }}">
            <trix-editor class="content-scroll" input="content"></trix-editor>
        </div>
        <button type="submit" class="btn btn-primary my-2">Save</button>
        <a href="{{ route('journals.show', $journal) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.js"></script>
