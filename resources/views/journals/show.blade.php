@include('layout.usernav')

@yield('usernav')
<div class="container">
        <div class="card mb-3">
            <div class="card-header">
                <h1 class="card-title">{{ $journal->title }}</h1>
            </div>
            <div class="card-body">
                <p class="card-text">{{ $journal->content }}</p>
                <p class="card-text"><small class="text-muted">Created at: {{ $journal->created_at }}</small></p>
            </div>
            <div class="card-footer">
                <a href="{{ route('journals.index') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('journals.edit', $journal) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('journals.destroy', $journal) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this journal?')">Delete</button>
                </form>
            </div>
        </div>
    </div>