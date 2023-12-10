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
            <!-- Search -->
            <div class="row">
                <!-- Channels -->
                @yield('Channel-Add')
                <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <!-- Search -->
                            <form action="{{ route('discussions.index') }}" method="GET">
                                <div class="input-group">
                                <input type="text" name="search" class="form-control" size="40" placeholder="Search by title" onkeyup="performLiveSearch(this.value)">                                    <div class="input-group-append">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-12" id="discussionList">
                    @if($discussions->isEmpty())
                    <div class="card my-4">
                        <div class="card-body d-flex justify-content-center align-items-center"> <!-- Utilizing flexbox classes -->
                        <div class="alert alert-info mb-0 text-center">Empty.</div>
                    </div>
                </div>
                    @else
                        @foreach($discussions as $discussion)
                            <div class="card mb-3 center">
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
                                            Course: {{ $discussion->course->courseName ?? 'None'}}
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
                <div id="live-search-results"></div>
            </div>
        </main>
    @endauth

    @yield('js')
</body>
</html>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="{{ asset('js/discussions.js') }}"></script>
<script>
    var searchUrl = '{{ route('discussions.index') }}';
</script>
