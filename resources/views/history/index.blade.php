@include('layout.usernav')

@section('content')
<head>
    <meta charset="utf-8">
    <title>GENER | History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/history.css') }}">
</head>

    <div class="container">

        <div class="d-flex justify-content-between align-items-center">
        <!-- Clear History -->
        <form action="{{ route('history.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">
                <i class="fas fa-broom"></i>
                Clear</button>
        </form>

        <!-- Search -->
        <form action="{{ route('history.search') }}" method="GET" class="ml-3">
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
                    <th></th>
                    <th>Title</th>
                    <th>Author</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @if ($resources->isEmpty())
                    <tr>
                        <td colspan="5">Your added history appears here.</td>
                    </tr>
                @else
                @foreach ($resources as $resource)
                <tr>
                    <!-- time in oct 10:00am format -->
                    <td>{{ $resource->created_at->format('M d, h:i A') }}</td>
                    <td>
                        <a class="hover" href="{{ route('resource.show', $resource->id) }}">
                            {{ Str::limit($resource->title, 35) }}
                        </a>
                    </td>
                    <td>{{ $resource->author }}</td>
                    <td>
                        <button class="btn btn-success mx-1" onclick="window.location='{{ route('resource.show', $resource->id) }}'">
                            <i class="fas fa-eye"></i>
                        </button>
                        <form action="{{ route('history.destroy', $resource->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger mx-1">
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
