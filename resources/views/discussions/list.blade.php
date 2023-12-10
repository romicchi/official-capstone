@foreach($discussions as $discussion)
    <div class="card mb-3 center">
        @include('partials.discussion-header')
        <div class="card-body shadow">
            <a href="{{ route('discussions.show', $discussion->slug) }}" class="card-link"> 
                <div class="card-text">
                    <div class="font-poppins-bold">
                        Description: 
                    </div>
                    {!! nl2br(Str::limit(strip_tags($discussion->content), 350)) !!}
                </div>
                <hr>
                <div>
                    @if ($discussion->author)
                    Author: {{ $discussion->author->firstname }} {{ $discussion->author->lastname }}
                    @else
                    Author: Unknown
                    @endif
                </div>
                <div>
                    Course: {{ $discussion->course->courseName ?? 'None'}}
                </div>
                <div>
                    Date: {{ $discussion->created_at->format('F d, Y') }}
                </div>
            </a>
        </div>
    </div>
@endforeach

{{ $discussions->appends(request()->query())->links() }}