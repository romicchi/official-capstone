@include('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Favorite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/favorite.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
</head>

@section('content')
    <div class="container">
        <h2 class="text-center">Favorite Resources</h2>

        <div class="d-flex justify-content-between align-items-center">
        <!-- Clear History -->
        <form action="{{ route('favorites.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger clear-favorite">
                <i class="fas fa-broom"></i>
                Clear</button>
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
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($resources->isEmpty())
                    <tr>
                        <td colspan="5">Your added favorite resources appears here.</td>
                    </tr>
                @else
                    @foreach ($resources as $resource)
                        <tr>
                            <td>
                                <a class="hover" href="{{ route('resource.show', $resource->id) }}">
                                {{ Str::limit($resource->title, 50) }}
                                </a>
                            </td>
                            <td>{{ $resource->author }}</td>
                            <td>
                            <form action="{{ route('favorites.destroy', $resource->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-favorite">
                                    <i class="fas fa-trash"></i>
                                </button>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>