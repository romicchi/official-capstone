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

    @error('title')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror

    @error('content')
    <div class="alert alert-danger">{{ $message }}</div>
    @enderror
        <div class="px-5">
            <div class="container card shadow">
                <div class="card-header"><strong>Add Discussion</strong></div>
                <div class="card-body">
                    <form action="{{ route('discussions.store')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="title"><strong>Title</strong></label>
                            <input type="text" name="title" class="form-control" value="">
                        </div>

                        <div class="form-group">
                            <label for="content"><strong>Content:</strong></label>
                            <br>
                            <input id="content" type="hidden" name="content">
                            <trix-editor class="content-scroll" input="content"></trix-editor>
                        </div>

                        <div class="form-group">
                            <label for="channel"><strong>Channel</strong></label>
                            <select name="channel" id="channel" class="form-control" required>
                                <option value="">Select a Channel</option>
                                @foreach($channels as $channel)
                                    <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="course"><strong>Course</strong></label>
                            <select name="course" id="course" class="form-control" required>
                                <option value="" disabled selected>Select a Channel first</option>
                                <!-- Options will be populated dynamically via JavaScript located below -->
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success my-2">Create Discussion</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Trix Editor JS -->
        @yield('js')
    </body>
</html>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const channelSelect = document.getElementById('channel');
        const courseSelect = document.getElementById('course');

        channelSelect.addEventListener('change', function() {
            const selectedChannelId = this.value;
            fetchCourses(selectedChannelId);
        });

        function fetchCourses(channelId) {
            const url = `/get-courses/${channelId}`;

            fetch(url)
                .then(response => response.json())
                .then(data => {
                    courseSelect.innerHTML = '';

                    data.forEach(course => {
                        const option = document.createElement('option');
                        option.value = course.id;
                        option.textContent = course.courseName;
                        courseSelect.appendChild(option);
                    });
                })
                .catch(error => console.error(error));
        }
    });
</script>