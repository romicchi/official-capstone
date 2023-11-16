@extends('layout.usernav')
@include('layout.forumlayout')

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>GENER | Discussion</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forum.css') }}">
    
    <!-- Trix Editor CSS -->
    @yield('css')
</head>
<body>
<main class="container py-4">
    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @error('content')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <a
        href="{{ route('discussions.show', $discussion->slug) }}"
    class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
    <div class="container card shadow">
        <div class="card-header"><strong>Edit Discussion</strong></div>
        <div class="card-body">
            <form action="{{ route('discussions.update', $discussion->id) }}" method="post">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="title">Title</label>
                    <input type="text" name="title" maxlength="255" class="form-control" value="{{ $discussion->title }}">
                </div>

                <div class="form-group">
                    <label for="content">Content:</label>
                    <br>
                    <input id="content" type="hidden" maxlength="3500" name="content" value="{{ $discussion->content }}">
                    <trix-editor class="content-scroll" input="content"></trix-editor>
                </div>

                <button type="submit" class="btn btn-success my-3">Update Discussion</button>
            </form>
        </div>
    </div>
</main>

<!-- Trix Editor JS -->
@yield('js')

</body>
</html>
