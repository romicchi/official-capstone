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
                <div class="col-md-8">
                    <div class="card">
                        @include('partials.discussion-header')
                        <!-- To display the content of the discussion -->
                        <div class="card-body">
                            <div class="text-center">
                                <strong> {{ $discussion->title }} </strong>
                            </div>
                            <hr>
                            {!! $discussion->content !!}
                        </div>
                    </div>

                    @foreach($discussion->replies()->paginate(3) as $reply)
                        <div class="card my-2">
                            <div class="card-header">
                                <span>{{ $reply->owner->name }}</span>
                            </div>
                            <div class="card-body">
                                {!! $reply->content !!}
                            </div>
                        </div>
                    @endforeach
                    <!-- Paginate for Reply -->
                    <div class="pagination">
                        {{ $discussion->replies()->paginate(3)->links('pagination::bootstrap-4') }}
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
                                <trix-editor input="content"></trix-editor>
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
        @yield('js')
    </body>
</html>