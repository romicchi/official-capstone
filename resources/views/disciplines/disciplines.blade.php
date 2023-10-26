
@if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
    @include('layout.adminnavlayout')
@else
    @include('layout.usernav')
@endif

<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/resources.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<head>
        
@section('content')
    <div class="container my-5">
        <h2 class="text-center"><strong>{{ $discipline->disciplineName }}</strong></h2>
        <div class="mb-3">
        </div>

        <div class="d-flex justify-content-end align-items-center">
            <!-- Search -->
            <form action="{{ route('disciplines.search', ['college_id' => $college->id, 'discipline_id' => $discipline->id]) }}" method="GET" class="ml-3">
                <div class="input-group">
                    <input type="search" class="form-control rounded-0" name="query" id="searchInput" placeholder="Search..." aria-label="Search" aria-describedby="search-btn" autocomplete="off">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

        <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Description</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resources as $resource)
                        <tr>
                            <td>{{ $resource->title }}</td>
                            <td>{{ $resource->author }}</td>
                            <td>{{ $resource->description }}</td>
                            <td>
                            <div class="d-flex justify-content-end">
                                <button class="btn btn-success mx-1" onclick="window.location='{{ route('resource.show', $resource->id) }}'">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <!-- download the resources-->
                                <button class="btn btn-primary mx-1" onclick="window.location='{{ route('resource.download', ['resource' => $resource]) }}'">
                                    <i class="fas fa-download"></i>
                                </button>
                                <button class="toggle-favorite" data-resource-id="{{ $resource->id }}">
                                    <i class="{{ auth()->user()->favorites->contains($resource) ? 'fas' : 'far' }} fa-star"></i>
                                </button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@show

<script>
    $(document).ready(function () {
        $('.toggle-favorite').click(function () {
            var resourceId = $(this).data('resource-id');
            var $starIcon = $(this).find('i');

            // Add the CSRF token to the data
            var csrfToken = $('meta[name="csrf-token"]').attr('content');
            var requestData = {
                resourceId: resourceId,
                _token: csrfToken, // Include the CSRF token
            };

            $.ajax({
                url: '{{ route('resource.toggleFavorite') }}',
                type: 'POST',
                data: requestData, // Send the updated data with the CSRF token
                success: function (data) {
                    if (data.isFavorite) {
                        $starIcon.removeClass('far').addClass('fas');
                    } else {
                        $starIcon.removeClass('fas').addClass('far');
                    }
                },
            });
        });
});

    // Track download of user
    function trackDownload(resourceId) {
            $.ajax({
                url: '{{ route('resource.trackDownload') }}',
                type: 'POST',
                data: { resourceId: resourceId, _token: '{{ csrf_token() }}' },
                success: function (data) {
                    // Handle success, e.g., show a message or update the UI.
                }
            });
        }
</script>

