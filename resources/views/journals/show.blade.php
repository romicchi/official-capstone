@extends('layout.usernav')

<link rel="stylesheet" type="text/css" href="{{ asset('css/journal.css') }}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

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
                    <button type="button" class="dropdown-item delete-journal">Delete</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <p class="card-text">{!! $journal->content !!}</p>
            <p class="card-text"><small class="text-muted">Created at: {{ $journal->created_at->format('F d, Y') }}</small></p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>
    function toggleDropdown() {
        var dropdownMenu = document.getElementById("dropdownMenu");
        dropdownMenu.classList.toggle("show");
    }

    $(document).ready(function() {
        $('.delete-journal').on('click', function() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Get the form element and submit it
                    var form = document.getElementById('deleteForm');
                    form.submit();

                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            });
        });
    });
</script>

<form id="deleteForm" action="{{ route('journals.destroy', $journal) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
