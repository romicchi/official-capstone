<div class="card-header"> 
    <!-- To display the author's email and the View button -->
    <div class="d-flex justify-content-between">
        <strong>{{ $discussion->author->email }}</strong> 
        <div>
            <!-- To add slug the title of the Discussions -->
            <a href="{{ route('discussions.show', $discussion->slug) }}" class="btn btn-success btn-sm">View</a>
            @if (auth()->check() && $discussion->user_id === auth()->user()->id)
                <form action="{{ route('discussions.destroy', $discussion) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            @endif
        </div>
    </div>
</div>
