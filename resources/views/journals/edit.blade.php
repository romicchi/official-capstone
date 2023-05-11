@include('layout.usernav')

@yield('usernav')
<div class="container">
    <h1>Edit Note</h1>
    <form action="{{ route('journals.update', $journal) }}" method="post">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="title">Title:</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $journal->title }}">
        </div>
        <div class="form-group">
            <label for="content">Content:</label>
            <textarea name="content" id="content" class="form-control">{{ $journal->content }}</textarea>
        </div>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>
</div>
