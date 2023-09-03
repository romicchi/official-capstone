@include('layout.usernav')

@section('content')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/favorite.css') }}">

    <div class="container">
    <h2 class="text-center">Favorite Resources</h2>

    @if ($resources->isEmpty())
        <p>No added favorite resources yet.</p>
    @else
        <table class="table">
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
                @foreach ($resources as $resource)
                    <tr>
                        <td>{{ $resource->title }}</td>
                        <td>{{ $resource->author }}</td>
                        <td>{{ $resource->description }}</td>
                        <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                        <td><a href="{{ route('resource.show', $resource->id) }}">View</a> |<td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@show