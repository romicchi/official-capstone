<!-- disciplines/list.blade.php -->

<div class="card shadow">
    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Type</th>
                    <th>Rating</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($resources as $resource)
                <tr>
                    <td>
                        <a class="hover" href="{{ route('resource.show', $resource->id) }}">{{ Str::limit($resource->title, 50) }}</a>
                    </td>
                    <td>{{ $resource->author }}</td>
                    <td>
                        {{ date('M. d, Y', strtotime($resource->publish_date)) }}
                    </td>
                    <td>{{ optional($resource->resourceType)->type ?? 'Empty' }}</td>
                    <td>
                        {{ number_format($resource->resourceRatings->avg('rating'), 2) }}
                    </td>
                    <td>
                        <div class="d-flex justify-content-end">
                            <button class="toggle-favorite" data-resource-id="{{ $resource->id }}">
                                <i class="{{ auth()->user()->favorites->contains($resource) ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>