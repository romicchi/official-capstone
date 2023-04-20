@include('layout.usernav')
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
        <!-- Nav Bar -->
        @yield('usernav')

        <!-- This will display the Channels in the Providers/AppServiceProvider -->
        @auth
            <main class="container py-4">
                <div class="row">
                    <!-- Channels -->
                        @yield('Channel-Add')
                    <div class="col-md-8">
                        @foreach($discussions as $discussion)
                            <div class="card mb-3">
                                <!-- To display the author email/name and display the title. Note: check the Discussion.php to see the function -->
                                @include('partials.discussion-header')
                                <!-- To display the content of the discussion -->
                                <div class="card-body">
                                    <div class="text-center">
                                        <strong> {{ $discussion->title }} </strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <!-- This will display the links above ex. https:librar-e.com/discussions?channel=bsit-channel$page=2 -->
                        {{$discussions->appends(['channel' => request()->query('channel')])->links()}} 
                    </div>
                </div>
            </main>
        @endauth

        @yield('js')
    </body>
</html>