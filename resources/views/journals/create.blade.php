@extends('layout.usernav')

<div class="container">
        <h1>Create New Journal</h1>
        <form action="{{ route('journals.store') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" class="form-control">
            </div>
            <div class="form-group">
                <label for="content">Content:</label>
                <textarea name="content" id="content" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>