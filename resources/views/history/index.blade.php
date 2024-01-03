@include('layout.usernav')

@section('content')
<head>
    <meta charset="utf-8">
    <title>GENER | History</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/history.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
</head>

    <div class="container">
    <div class="h4 font-poppins-bold">Notes History</div>

        <div class="d-flex justify-content-between align-items-center flex-wrap">
        <!-- Search -->
        <form action="{{ route('history.search') }}" method="GET" class="ml-3">
            <div class="input-group">
                <input type="search" class="form-control rounded-0" name="query" id="searchInput" placeholder="Search by Title..." aria-label="Search" aria-describedby="search-btn" oninput="performLiveSearch(this.value)">
            </div>
        </form>

        <!-- Clear History -->
        <form action="{{ route('history.clear') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger clear-history">
                <i class="fas fa-broom"></i>
                Clear</button>
        </form>
    </div>
    <div id="history-table-container">
        <div class="card shadow mb-4">
            <div class="card-body">
        <table class="table table-hover">
            <thead class="table">
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Type</th>
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
                <tr class="font-poppins-bold">
                    <!--history created_at time in oct 10:00am format -->
                    <td>{{ $resource->histories->last()->created_at->format('M d, h:i A') }}</td>
                    <td>
                        <a class="hover" href="{{ route('resource.show', $resource->id) }}">
                            {{ Str::limit($resource->title, 35) }}
                        </a>
                    </td>
                    <td>{{ $resource->author }}</td>
                    <td>{{ date('M. d, Y', strtotime($resource->publish_date)) }}</td>
                    <td>{{ optional($resource->resourceType)->type ?? 'Empty' }}</td>
                    <td>
                        <form action="{{ route('history.destroy', $resource->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn mx-1 delete-history" title="Delete">
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
    var searchUrl = '{{ route('history.search') }}';
</script>
<script src="{{ asset('js/historyManagesearch.js') }}"></script>
