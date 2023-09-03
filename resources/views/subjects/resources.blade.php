@if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
    @include('layout.adminnavlayout')
@else
    @include('layout.usernav')
@endif

<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link rel="stylesheet" type="text/css" href="{{ asset('css/resources.css') }}">
<meta name="csrf-token" content="{{ csrf_token() }}">
<head>
    <style>
        button.toggle-favorite {
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
        }  
    </style>

@section('content')
<div class="container">
        <h2 class="text-center">Resources for {{ $subject->subjectName }}</h2>

        @if ($resources)
            <table class="table">
                <thead class="table-dark">
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
						<th>Description</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resources as $resource)
                        <tr>
                            <td>{{ $resource->title }}</td>
                            <td>{{ $resource->author }}</td>
                            <td>{{ $resource->description }}</td>
                            <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                            <td>
                            <a href="{{ route('resource.show', $resource->id) }}">View</a> |
                            <button class="toggle-favorite" data-resource-id="{{ $resource->id }}">
                                <i class="{{ auth()->user()->favorites->contains($resource) ? 'fas' : 'far' }} fa-star"></i>
                            </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>No resources available for {{ $subject->subjectName }}</p>
        @endif
    </div>
    @show

    <script src="{{ asset('js/resourcelivesearch.js') }}"></script>
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
</script>
