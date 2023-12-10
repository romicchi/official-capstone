<div class="card shadow mb-4">
            <div class="card-body">
        <table class="table table-hover">
            <thead class="table">
                <tr>
                    <th></th>
                    <th>Title</th>
                    <th>Uploader</th>
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
                    <!-- time in oct 10:00am format -->
                    <td>{{ $resource->created_at->format('M d, h:i A') }}</td>
                    <td>
                        <a class="hover" href="{{ route('resource.show', $resource->id) }}">
                            {{ Str::limit($resource->title, 35) }}
                        </a>
                    </td>
                    <td>{{ $resource->author }}</td>
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