<div class="card shadow mb-4">
            <div class="card-body">
        <table class="table table-hover" id="favoriteTable">
            <thead class="table">
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Published Date</th>
                    <th>Action</th>
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