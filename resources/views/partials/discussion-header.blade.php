<div class="card-header">
    <!-- To display the author's email and the View and Delete buttons -->
    <div class="d-flex justify-content-between">
        <strong>{{ $discussion->author->firstname }} {{ $discussion->author->lastname }}</strong>
        <div>
            <a href="{{ route('discussions.show', $discussion->slug) }}" class="btn btn-success btn-sm">View</a>
            <!-- To add slug the title of the Discussions -->
            @if (auth()->check() && auth()->user()->id == $discussion->user_id)
            <form action="{{ route('discussions.destroy', $discussion) }}" method="POST" class="d-inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
            </form>
            @endif
        </div>
    </div>
</div>

