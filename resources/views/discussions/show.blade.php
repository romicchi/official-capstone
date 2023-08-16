@extends('layout.usernav')
@include('layout.forumlayout')

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Forum</title>
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
                <!-- Yield will add the Channels as well as the Add Discussion Button in the layout -->
                @yield('Channel-Add')
                <div class="col-md-8 my-2">
                    <div class="card">
                        @include('partials.discussion-header')
                        <!-- To display the content of the discussion -->
                        <div class="card-body content-scroll">
                            <div>
                                Author: {{ $discussion->author->firstname }} {{ $discussion->author->lastname }}
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


                    <h4 class="mt-4">Comments</h4>
                    @foreach($replies as $reply)
                    <div class="card my-2">
                        @php
                        $replyHeaderClass = auth()->check() && auth()->user()->id == $reply->owner->id ? 'yellow' : 'green';
                        @endphp
                        <div class="card-header reply-header {{ $replyHeaderClass }}">
                            <span><strong>{{ $reply->owner->firstname }} {{ $reply->owner->lastname }}</strong></span>
                            @if (auth()->check() && auth()->user()->id == $reply->owner->id)
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
                            <p class="card-text"><small class="text-muted">Created at: {{ $reply->created_at->format('F d, Y') }}</small></p>
                        </div>
                    </div>
                    @endforeach
                    <!-- Paginate for Reply -->
                    <div class="pagination">
                    {{ $replies->links('pagination::bootstrap-4') }}
                    </div>
                    
                    <div class="card my-4"> 
                        <div class="card-header">
                            <strong>Reply</strong>
                        </div>
                        
                        <div class="card-body">
                            <!-- action to submit the reply. route discussion->slug is the discussion id -->
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


<script>
    $(document).ready(function() {
        $('.delete-reply').on('click', function() {
            var replyId = $(this).data('reply-id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get the form element and submit it
                    var form = document.getElementById('deleteReplyForm_' + replyId);
                    form.submit();

                    Swal.fire(
                        'Deleted!',
                        'Your reply has been deleted.',
                        'success'
                    )
                }
            });
        });
    });
    
</script>

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