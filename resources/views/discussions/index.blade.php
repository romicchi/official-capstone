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
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forum.css') }}">
    @yield('css')
</head>
<body>
    <!-- This will display the Channels in the Providers/AppServiceProvider -->
    @auth
        <main class="container py-4">
            <div class="row">
                <!-- Channels -->
                @yield('Channel-Add')
                <div class="col-md-8">
                    @if($discussions->isEmpty())
                        <div class="card my-4">
                            <div class="card-body">
                                <div class="alert alert-info mb-0 text-center">Channel is currently empty.</div>
                            </div>
                        </div>
                    @else
                        @foreach($discussions as $discussion)
                            <div class="card mb-3">
                                <!-- To display the author email/name and display the title. Note: check the Discussion.php to see the function -->
                                @include('partials.discussion-header')
                                <!-- To display the content of the discussion -->
                                <div class="card-body shadow">
                                    <a href="{{ route('discussions.show', $discussion->slug) }}" class="card-link"> 
                                        <!-- content with Str limit -->
                                        <div class="card-text">
                                            <div class="font-poppins-bold">
                                                Description: 
                                            </div>
                                            {!! nl2br(Str::limit(strip_tags($discussion->content), 350)) !!}
                                        </div>
                                        <hr>
                                        <div>
                                            @if ($discussion->author)
                                            Author: {{ $discussion->author->firstname }} {{ $discussion->author->lastname }}
                                            @else
                                            Author: Unknown
                                            @endif
                                        </div>
                                        <div>
                                            Course: {{ $discussion->course->courseName }}
                                        </div>
                                        <div>
                                            Date: {{ $discussion->created_at->format('F d, Y') }}
                                        </div>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                        <!-- This will display the links above .com/discussions?channel=bsit-channel&page=2 -->
                        {{ $discussions->appends(request()->query())->links() }}
                    @endif
                </div>
            </div>
        </main>
    @endauth

    @yield('js')
</body>
</html>
