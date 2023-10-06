@section('resourcelayout')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/resources.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/table.css')}}">

    <h3 class="title-subject">@yield('title')</h3>

    <br><br>
    <center>
        <form class="table-responsive table-wrapper">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Description</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($resources as $resource)
                    <tr>
                        <td><strong>{{ $resource->title }}<strong></td>
                        <td>{{ $resource->author }}</td>
                        <td>{{ $resource->description }}</td>
                        <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                        <td><a class="btn btn-primary" href="/embed/{{ $resource->id }}">View</a>
                        <a class="btn btn-danger" href="{{ $resource->url }}" target="_blank">Download</a>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </form>
    </center>
@show
