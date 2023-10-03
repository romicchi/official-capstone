<link rel="stylesheet" href="{{ asset('css/comment.css') }}">

<div class="comments">
    <h3>Comments</h3>

    @if ($comments->count() > 0)
        <ul class="list-group">
            @foreach ($comments as $comment)
                <li class="list-group-item">
                    <div class="comment-header">
                        <strong>{{ $comment->user->firstname }}</strong> commented:
                    </div>
                    <div class="comment-body {{ strlen($comment->comment_text) > 100 ? 'scrollable' : '' }}">
                        <p>{{ $comment->comment_text }}</p>
                    </div>
                    @if (auth()->user()->id === $comment->user_id)
                        <div class="comment-footer">
                            <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        <!-- Pagination is located in Resource Controller in show function $comment -->
        <div class="d-flex justify-content-center my-1">
            {{ $comments->onEachSide(1)->links('pagination::bootstrap-4') }}
        </div>
    @else
        <p>No comments yet.</p>
        <p>Be the first to leave a comment.</p>
    @endif
</div>
