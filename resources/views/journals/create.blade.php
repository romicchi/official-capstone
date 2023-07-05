@extends('layout.usernav')

<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/journal.css') }}">

@error('content')
<div class="alert alert-danger">{{ $message }}</div>
@enderror

@error('title')
<div class="alert alert-danger">{{ $message }}</div>
@enderror


<div class="container card">
    <h2 class="card-header">Create New Journal</h2>
    <form action="{{ route('journals.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group trix-container">
            <label for="content">Content:</label>
            <input id="content" type="hidden" name="content">
            <trix-editor class="content-scroll" input="content"></trix-editor>
        </div>
        <button type="submit" class="btn btn-primary my-2">Create</button>
        <a href="{{ route('journals.index') }}" class="btn btn-secondary">Back</a>
    </form>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.js"></script>
