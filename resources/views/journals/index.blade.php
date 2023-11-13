@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Journal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/journal.css') }}">
</head>

<h1>Study Journal</h1>

<div class="container shadow">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('journals.create') }}" class="btn btn-primary mx-2">+ Create Journal</a>
        </div>
    </div>
    <hr>

    <form action="{{ route('journals.index') }}" method="GET" class="my-3">
        <div class="input-group">
            <select name="discipline" class="form-control">
                <option value="">All Disciplines</option>
                @foreach ($disciplines as $discipline)
                    <option value="{{ $discipline->id }}">{{ $discipline->disciplineName }}</option>
                @endforeach
            </select>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Filter</button>
            </div>
        </div>
    </form>

    <form action="{{ route('journals.index') }}" method="GET" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search by title" value="{{ $search }}">
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </div>
    </form>

    <div id="journal-list">
        @if ($journals->count() > 0)
            @foreach ($journals as $journal)
                <a href="{{ route('journals.show', $journal) }}" class="card-link">
                    <div class="card mb-3">
                        <div class="card-body shadow">
                            <h5 class="card-title">{{ $journal->title }}</h5>
                            <p class="card-text p1">{{ $journal->discipline->disciplineName }}</p>
                            <p class="card-text p1">{{ $journal->created_at->format('F d, Y') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        @else
            <p>No journals found.</p>
        @endif
    </div>
    
    <div class="d-flex justify-content-center">
        {{ $journals->appends(['search' => $search])->links('pagination::bootstrap-4') }}
    </div>
</div>
