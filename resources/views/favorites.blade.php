@include('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Favorite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/favorite.css') }}">
</head>

@section('content')
    <div class="container">
        <h2 class="text-center">Favorite Resources</h2>

        <div class="d-flex justify-content-between align-items-center">
        <!-- Clear History -->
        <form action="{{ route('favorites.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Clear Favorites</button>
        </form>

        <!-- Search -->
        <form action="{{ route('favorites.search') }}" method="GET" class="ml-3">
            <div class="input-group">
                <input type="search" class="form-control rounded-0" name="query" id="searchInput" placeholder="Search user" aria-label="Search" aria-describedby="search-btn">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

        <div class="card shadow mb-4">
            <div class="card-body">
        <table class="table table-hover">
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
                            <td><a href="{{ route('resource.show', $resource->id) }}">View</a> |
                            <form action="{{ route('favorites.destroy', $resource->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-danger">Delete</button>
                            </form>
                        </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
        <div class="d-flex justify-content-center">
            {{ $resources->appends(['query' => request('query')])->links('pagination::bootstrap-4') }}
        </div>
    </div>
    </div>
    </div>
@show
