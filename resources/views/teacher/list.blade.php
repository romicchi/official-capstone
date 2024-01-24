<table class="table">
    <thead>
        <tr>
        <th>Title</th>
        <th>Author</th>
        <th>Published Date</th>
        <th>College</th>
        <th>Discipline</th>
        <th>Type</th>
        <th>Downloadable</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @if(count($resources) === 0)
        <tr>
            <td colspan="7">No resource found.</td>
        </tr>
        @else
        @foreach($resources as $resource)
        <tr class="font-poppins-bold">
            <td>
                <!-- if College and Discipline is null then title link is not clickable -->
                @if(!is_null($resource->college))
                <a class="hover" href="{{ route('resource.show', $resource->id) }}">
                    <strong>{{ Str::limit($resource->title, 35) }}</strong>
                </a>
                @else
                <strong>{{ Str::limit($resource->title, 35) }}</strong>
                @endif
            </td>
            <td>{{ $resource->author ?? 'Empty' }}</td>
            <td>{{ $resource->publish_date && strtotime($resource->publish_date) ? date('M. d, Y', strtotime($resource->publish_date)) : 'Empty' }}</td>
            <td>{{ optional($resource->college)->collegeName ?? 'Empty' }}</td>
            <td>{{ optional($resource->discipline)->disciplineName ?? 'Empty' }}</td>
            <td>{{ optional($resource->resourceType)->type ?? 'Empty' }}</td>
            <td>{{ $resource->downloadable ? 'Yes' : 'No' }}</td>
            <td>
                <button class="btn mx-1" onclick="window.location='{{ route('resources.edit', $resource->id) }}'" title="Edit">
                    <i class="fas fa-edit"></i>
                </button>
                <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn delete-resource-confirm" title="Delete">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>