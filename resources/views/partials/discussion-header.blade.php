<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forum.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="card-header text-center header">
    <!-- To display the author's email and the View and Delete buttons -->
    <div class="d-flex justify-content-between align-items-center">
        @if (Route::currentRouteName() === 'discussions.index')
            <a href="{{ route('discussions.show', $discussion->slug) }}" class="card-link"> 
                <strong>{{ Str::limit($discussion->title, $characterLimit) }}</strong>
            </a>
        @else
            <strong>{{ Str::limit($discussion->title, $characterLimit) }}</strong>
        @endif
        @if (auth()->check() && auth()->user()->id == $discussion->user_id)
         <div class="dots-container" onclick="toggleDropdown('dropdownMenu_{{ $discussion->id }}')">
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dot"></div>
                <div class="dropdown-menu menu" id="dropdownMenu_{{ $discussion->id }}">
                    <a class="dropdown-item" href="{{ route('discussions.edit', ['discussion' => $discussion->id]) }}">Edit</a>
                    <button type="button" class="dropdown-item delete-discussion">Delete</button>
                </div>
            </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

<script>

    function toggleDropdown(dropdownId) {
        var dropdownMenu = document.getElementById(dropdownId);
        dropdownMenu.classList.toggle("show");
    }

    $(document).on('click', function(event) {
        // Check if the clicked element is not part of the dropdown or its toggle button
        if (!$('.dots-container').is(event.target) && $('.dots-container').has(event.target).length === 0) {
            // Close any open dropdowns
            $('.menu').removeClass('show');
        }
    });
        
    $(document).ready(function() {
        $('.delete-discussion').on('click', function() {
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
                        'Your discussion has been deleted.',
                        'success'
                    )
                }
            });
        });
    });

</script>

<form id="deleteForm" action="{{ route('discussions.destroy', $discussion) }}" method="POST" class="d-none">
    @csrf
    @method('DELETE')
</form>
