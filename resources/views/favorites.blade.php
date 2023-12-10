@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Favorite</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/favorite.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
</head>

@section('content')
    <div class="container">
        
        <div class="h4 font-poppins-bold">Favorite Resources</div>
        <div class="d-flex justify-content-between align-items-center flex-wrap">
        <!-- Search -->
        <form action="{{ route('favorites.search') }}" method="GET" class="ml-3">
            <div class="input-group">
            <input type="text" class="form-control" size="30" id="searchInput" name="query" placeholder="Search by Title..." onkeyup="performLiveSearch(this.value)" value="{{ request('query') }}">
            </div>
        </form>

        <!-- Clear History -->
        <form action="{{ route('favorites.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger clear-favorite">
                <i class="fas fa-broom"></i>
                Clear</button>
        </form>
    </div>

    <div id="favorite-table-container">
        <div class="card shadow mb-4">
            <div class="card-body">
        <table class="table table-hover" id="favoriteTable">
            <thead class="table">
                <tr>
                    <th>Title</th>
                    <th>Uploader</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($resources->isEmpty())
                    <tr>
                        <td colspan="5">Your added favorite resources appear here.</td>
                    </tr>
                @else
                    @foreach ($resources as $resource)
                        <tr class="font-poppins-bold">
                            <td>
                                <a class="hover" href="{{ route('resource.show', $resource->id) }}" data-toggle="popover" title="Resource Details" data-content="Click to view details">
                                {{ Str::limit($resource->title, 50) }}
                                </a>
                            </td>
                            <td>{{ $resource->author }}</td>
                            <td>
                            <form action="{{ route('favorites.destroy', $resource->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn delete-favorite" data-bs-toggle="popover" data-bs-trigger="hover focus" title="Delete" data-content="Click to remove from favorites">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach

                @endif
            </tbody>
        </table>
    </div>
</div>
</div>
<div id="live-search-results">
<div class="d-flex justify-content-center">
    {{ $resources->appends(['query' => request('query')])->links('pagination::bootstrap-4') }}
</div>
</div>
@show

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script>
    // Initialize Bootstrap popovers
    $(function () {
        $('[data-toggle="popover"]').popover();
    });

    var searchUrl = '{{ route('favorites.search') }}';
</script>
<script src="{{ asset('js/favoritesManagesearch.js') }}"></script>
