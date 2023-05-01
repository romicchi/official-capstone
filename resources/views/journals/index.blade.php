@include('layout.usernav')

@yield('usernav')
<div class="container">
        <h1>Study Journal</h1>
        <a href="{{ route('journals.create') }}" class="btn btn-primary">Create Journal</a>
        <hr>

        @foreach ($journals as $journal)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $journal->title }}</h5>
                    <p class="card-text">Content: {{ $journal->content }}</p>
                    <p class="card-text">Created at: {{ $journal->created_at }}</p>
                    <a href="{{ route('journals.show', $journal) }}" class="btn btn-primary">View</a>
                    <a href="{{ route('journals.edit', $journal) }}" class="btn btn-secondary">Edit</a>
                    <form action="{{ route('journals.destroy', $journal) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this journal?')">Delete</button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>
