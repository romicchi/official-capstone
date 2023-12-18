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
    @auth
    <main class="container py-4">
        <div class="row">
            <div class="col-md-12 my-2">
                <a href="{{ route('discussions.index') }}" class="btn btn-primary mb-3"><i class="fas fa-arrow-left"></i> Back</a>
                <div class="card">
                    @include('partials.discussion-header')
                    <!-- To display the content of the discussion -->
                    <div class="card-body content-scroll shadow">
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
                        <br>
                        {!! $discussion->content !!}
                        <br>
                        <p class="card-text"><small class="text-muted">Created at: {{ $discussion->created_at->format('F d, Y') }}</small></p>
                    </div>
                </div>

                <div class="mt-5 h5 font-poppins-bold">Comments</div>
                @foreach($replies as $reply)
                <div class="card my-2 shadow">
                    @php
                    $replyHeaderClass = auth()->check() && $reply->owner && auth()->user()->id == $reply->owner->id ? 'yellow' : 'green';
                    @endphp
                    <div class="card-header reply-header {{ $replyHeaderClass }}">
                        <span><strong>{{ optional($reply->owner)->firstname }} {{ optional($reply->owner)->lastname }}</strong></span>
                        @if (auth()->check() && $reply->owner && auth()->user()->id == $reply->owner->id)
                        <div class="dots-container dropdown-trigger" onclick="toggleDropdown('dropdownmenu_{{ $reply->id }}')">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dropdown-menu" id="dropdownmenu_{{ $reply->id }}">
                                <button type="button" class="dropdown-item delete-reply" data-reply-id="{{ $reply->id }}">Delete</button>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="card-body">
                        {!! $reply->content !!}
                        <br>
                        <p class="card-text"><small class="text-muted">{{ $reply->created_at->diffForHumans() }}</small></p>
                    </div>
                </div>
                @endforeach
                <!-- Paginate for Reply -->
                <div class="pagination">
                    {{ $replies->links('pagination::bootstrap-4') }}
                </div>

                <div class="card my-4 shadow">
                    <div class="card-header">
                        <strong>Reply</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('replies.store', $discussion->slug) }}" method="POST">
                            @csrf
                            <input type="hidden" name="content" id="content">
                            <trix-editor class="trix-container" input="content"></trix-editor>
                            <button type="submit" class="btn btn-sm my-2 btn-success">
                                Add Reply
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endauth

<!-- Add the form for each reply -->
@foreach($discussion->replies as $reply)
    <form id="deleteReplyForm_{{ $reply->id }}" action="{{ route('replies.destroy', ['discussion' => $discussion->slug, 'reply' => $reply->id]) }}" method="POST" class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endforeach

        @yield('js')
    </body>
</html>

<!-- js link -->
<script src="{{ asset('js/discussions.js') }}"></script>