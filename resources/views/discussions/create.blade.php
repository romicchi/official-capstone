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
   
        <link rel="stylesheet" type="text/css" href="{{ asset('')}}">
        <!-- Trix Editor CSS -->
        @yield('css')
    </head>
    <body>
        <!-- Nav Bar -->
        @yield('usernav')
        <br>
        <div class="container card">
            <div class="card-header">Add Discussion</div>
            <div class="card-body">
                <form action="{{ route('discussions.store')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" class="form-control" value="">
                    </div>

                    <div class="form-group">
                        <label for="content">Content</label>
                        <br>
                        <input id="content" type="hidden" name="content">
                        <trix-editor input="content"></trix-editor>
                    </div>

                    <div class="form-group">
                        <label for="channel">Channel</label>
                        <select name="channel" id="channel" class="form-control">
                            @foreach($channels as $channel)
                                <option value="{{ $channel->id }}">{{ $channel->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-success">Create Discussion</button>
                </form>
            </div>
        </div>

        <!-- Trix Editor JS -->
        @yield('js')
    </body>
</html>