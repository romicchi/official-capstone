@include('layout.usernav')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/favorite.css') }}">

    <div class="container">
        <h2 class="text-center">Favorite Resources</h2>

        <div class="card shadow mb-4">
            <div class="card-body">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>File</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @if ($resources->isEmpty())
                    <tr>
                        <td colspan="5">No added favorite resources yet.</td>
                    </tr>
                @else
                    @foreach ($resources as $resource)
                        <tr>
                            <td>{{ $resource->title }}</td>
                            <td>{{ $resource->author }}</td>
                            <td>{{ $resource->description }}</td>
                            <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                            <td><a href="{{ route('resource.show', $resource->id) }}">View</a> |</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $resources->links('pagination::bootstrap-4') }}
        </div>
    </div>
    </div>
    </div>
@show
