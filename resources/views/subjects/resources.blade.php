@if(auth()->user()->role_id == 3)
    @include('layout.adminnavlayout')
@else
    @include('layout.usernav')
@endif

@section('content')
<div class="container">
        <h2 class="text-center">Resources for {{ $subject->subjectName }}</h2>

        @if ($resources)
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
                            <td>
                            <a href="{{ route('resource.show', $resource->id) }}">View</a> |
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No resources available for {{ $subject->subjectName }}</p>
        @endif
    </div>

    <script src="{{ asset('js/resourcelivesearch.js') }}"></script>
@show