@if ($journals->count() > 0)
    @foreach ($journals as $journal)
        <a href="{{ route('journals.show', $journal) }}" class="card-link">
            <div class="card mb-3">
                <div class="card-body shadow">
                    <h5 class="card-title font-poppins-bold">{{ $journal->title }}</h5>
                    <p class="card-text p1">{{ $journal->discipline->disciplineName }}</p>
                    <p class="card-text p1">{{ $journal->created_at->format('F d, Y') }}</p>
                </div>
            </div>
        </a>
    @endforeach
@else
    <p>No journals found.</p>
@endif
