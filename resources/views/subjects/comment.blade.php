<link rel="stylesheet" href="{{ asset('css/comment.css') }}">

<div class="comments shadow">
    <h3>Comments</h3>

    @if ($comments->count() > 0)
        <ul class="list-group">
            @foreach ($comments as $comment)
                <li class="list-group-item">
                    <div class="comment-header">
                        <strong>{{ $comment->user->firstname }}</strong> commented:
                        @if (auth()->user()->id === $comment->user_id)
                        <div class="dots-container" onclick="toggleCommentDropdown(event, 'commentDropdown_{{ $comment->id }}')">
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dot"></div>
                            <div class="dropdown-menu menu" id="commentDropdown_{{ $comment->id }}">
                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-option">
                                        <!-- fas delete -->
                                        <i class="fas fa-trash"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="comment-body {{ strlen($comment->comment_text) > 400 ? 'scrollable' : '' }}">
                        <p style="word-wrap: break-word;">{{ $comment->comment_text }}</p>
                        <small>{{ $comment->created_at->diffForHumans() }}</small>

                    </div>
                </li>
            @endforeach
        </ul>

        <!-- Pagination is located in Resource Controller in show function $comment -->
        <div class="d-flex justify-content-center my-1">
            {{ $comments->links('pagination::bootstrap-4') }}
        </div>
    @else
        <p>No comments yet.</p>
        <p>Be the first to leave a comment.</p>
    @endif
</div>

<script>
    function toggleCommentDropdown(event, dropdownId) {
        event.stopPropagation();
        const dropdown = document.getElementById(dropdownId);
        dropdown.classList.toggle('show');
    }

    $(document).on('click', function(event) {
        // Check if the clicked element is not part of the dropdown or its toggle button
        if (!$('.dots-container').is(event.target) && $('.dots-container').has(event.target).length === 0) {
            // Close any open dropdowns
            $('.menu').removeClass('show');
        }
    });

</script>
