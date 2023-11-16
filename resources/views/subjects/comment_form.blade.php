<link rel="stylesheet" href="{{ asset('css/comment.css') }}">

@auth
    <div class="comment-form card mt-4 shadow">
        <div class="card-body">
            <h4 class="card-title">Add a Comment</h4>
            <form method="POST" action="{{ route('comments.store') }}">
                @csrf
                <div class="form-group">
                    <textarea name="comment_text" class="form-control" rows="3" placeholder="Enter your comment" required></textarea>
                </div>
                <input type="hidden" name="resource_id" value="{{ $resource->id }}">
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@else
    <div class="comment-form mt-4">
        <p>Please <a href="{{ route('login') }}">login</a> to add comments.</p>
    </div>
@endauth
