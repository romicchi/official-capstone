@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/journal.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
</head>

<div class="container">
    <a href="{{ route('journals.index') }}" class="back-button">← Back</a>
    <div class="card mb-3 my-3">
        <div class="card-header">
            <h3 class="card-title">{{ $journal->title }}</h3>
            <div class="dots-container" onclick="toggleDropdown()">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dropdown-menu" id="dropdownMenu">
                    <a class="dropdown-item" href="{{ route('journals.edit', $journal) }}">Edit</a>
                    <a class="dropdown-item" href="{{ route('journals.download-pdf', $journal) }}" class="btn btn-primary">Download</a>
                    <button type="button" class="dropdown-item delete-journal">Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body shadow">
            <p>{!! $journal->content !!}</p>
            <p class="card-text"><small class="text-muted">Created at: {{ $journal->created_at->format('F d, Y') }}</small></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>


<form id="deleteForm" action="{{ route('journals.destroy', $journal) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>

<script src="{{ asset('js/journal.js') }}"></script>