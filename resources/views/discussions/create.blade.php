@extends('layout.usernav')
@include('layout.forumlayout')

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GENER | Discussion</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forum.css') }}">
    <!-- Trix Editor CSS -->
    @yield('css')
</head>
<body>

<br>

<div class="px-5">
    <div class="container card shadow">
        <div class="card-header"><strong>Add Discussion</strong></div>
        <div class="card-body">
            <form action="{{ route('discussions.store')}}" method="post">
                @csrf
                <div class="form-group">
                    <label for="title"><strong>Title</strong></label>
                    <input type="text" name="title" id="title" maxlength="255" class="form-control" value="{{ old('title') }}">
                    @error('title')
                    <small _ngcontent-irw-c66 class="text-danger">* {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="content"><strong>Content:</strong></label>
                    <br>
                    <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                    <trix-editor class="content-scroll" input="content"></trix-editor>
                    @error('content')
                    <small _ngcontent-irw-c66 class="text-danger">* {{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="channel"><strong>Channel</strong></label>
                    <select name="channel" id="channel" class="form-control">
                        <option value="">Select a Channel</option>
                        @foreach($channels as $channel)
                            <option value="{{ $channel->id }}" {{ old('channel') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                        @endforeach
                    </select>
                    @error('channel')
                    <small _ngcontent-irw-c66 class="text-danger">* Channel is required.</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="course"><strong>Course</strong></label>
                    <select name="course" id="course" class="form-control">
                        <option value="" disabled selected>Select a Channel first</option>
                    </select>
                    @error('course')
                    <small _ngcontent-irw-c66 class="text-danger">* Course is required.</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success my-2">Create Discussion</button>
                <a href="{{ route('discussions.index') }}" class="btn btn-secondary my-2">Cancel</a>
            </form>
        </div>
    </div>
</div>

<!-- Trix Editor JS -->
@yield('js')
</body>
</html>

<script src="{{ asset('js/discussions.js') }}"></script>