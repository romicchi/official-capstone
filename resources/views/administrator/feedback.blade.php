@extends('layout.adminnavlayout')

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/feedback.css')}}">
</head>

<div class="h4 font-poppins-bold">Feedbacks</div>

<div class="container">
    @foreach($feedbacks as $feedback)
    <div class="card mb-3">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <p class="card-text"><small class="text-muted">{{ $feedback->name }}</small></p>
                <p class="card-text"><small class="text-muted">{{ $feedback->email }}</small></p>
            </div>
            <form action="{{ route('feedback.destroy', $feedback->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn delete-resource-confirm" title="Delete">
                    <i class="fas fa-trash-alt p-1"></i>
                </button>
            </form>
        </div>
        <div class="card-header font-poppins-bold">Title: {{ $feedback->title }}</div>
        <div class="card-body">
            <p class="card-text">
                <div class="font-poppins-bold">
                    Description: 
                </div>
                {{ Str::limit($feedback->content, 500) }}
            </p>
            <p class="card-text"><small class="text-muted">{{ $feedback->category->name }}</small></p>
            <p class="card-text"><small class="text-muted">{{ $feedback->created_at->format('M d, Y h:i A') }}</small></p>
        </div>
    </div>
    @endforeach
</div>

<!-- Pagination links -->
<div class="d-flex justify-content-center my-3">
    {{ $feedbacks->onEachSide(3)->links('pagination::bootstrap-4') }}
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/resourceManagesearch.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>