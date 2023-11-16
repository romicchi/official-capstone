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
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
        <style>
            th {
                color: black;
            }
            h4 {
                font-size: 20px;
            }
            p {
                font-size: 16px;
            }

            .button {
    display: inline-block;
    padding: 10px 20px;
    background-color: #007bff; /* You can change the background color to your preference */
    color: #fff;
    text-align: center;
    text-decoration: none;
    border-radius: 5px;
    margin: 5px;
    cursor: pointer;
}

.button:hover {
    background-color: #0056b3; /* Change the hover color as needed */
}

.thead {
    color: white !important;
}

.justified-text {
    text-align: justify;
}

button.toggle-favorite {
  background: none;
  color: #f1c40f;
  border: none;
  padding: 0;
  cursor: pointer;
}  

.toggle-favorite {
        display: inline-block;
    }

    .title-with-star {
        display: flex;
        align-items: center; /* Vertically align the star and title */
    }

    .add-to-favorites-hint {
        font-size: 12px; /* Adjust the font size as needed */
        color: #777; /* Grey color */
        margin-left: 5px; /* Add some spacing between the text and the star */
    }

    </style>

@section('content')
    <div class="container">
        <h2>Relevant Resources</h2>
        <table class="table table-bordered">
        <thead>
        <tr>
            <th class="thead"> </th>
            <th class="thead">Keywords</th>
            <th class="thead">Description/Summary</th>
            <th class="thead">Action</th>
        </tr>
    </thead>
        <tbody>
            @foreach ($resources as $resource)
                <tr>
                    <td>
                        <h4>
                            <div class="title-with-star">
                                <button class="toggle-favorite" data-resource-id="{{ $resource->id }}">
                                    <i class="{{ auth()->user()->favorites->contains($resource) ? 'fas fa-star' : 'far fa-star' }}"></i>
                                </button>
                                <span class="add-to-favorites-hint">(Add to Favorites)</span>
                            </div>
                            <a href="{{ url('resource/show', $resource->id) }}">{{ $resource->title }}</a>
                        </h4>
                        <p><strong>Uploader:</strong> {{ $resource->author }}</p>
                        <p><strong>Discipline:</strong> {{ $resource->college->collegeName }} > {{ $resource->discipline->disciplineName}}</p>
                    </td>
                    <td>{{ $resource->keywords }}</td>
                    <td class="justified-text">{{ $resource->description }}</td>
                    <td>
                    <a href="{{ url('resource/show', $resource->id) }}" class="button">View</a>
                    <!-- download the resources-->
                    <a href="{{ route('resource.download', ['resource' => $resource]) }}"
                                onclick="trackDownload('{{ $resource->id }}')" class="button">Download</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@show

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Toggle favorite
$(document).ready(function () {
    $('.toggle-favorite').click(function () {
        var resourceId = $(this).data('resource-id');
        var $starIcon = $(this).find('i');

        // Add the CSRF token to the data
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '{{ route('resource.toggleFavorite') }}',
            type: 'POST',
            data: { resourceId: resourceId, _token: csrfToken },
            success: function (data) {
                // Toggle the class of the star icon
                $starIcon.toggleClass('fas far');

                // Update the number of favorites in the UI
                var $favoritesCount = $('.favorites-count');
                if ($favoritesCount.length) {
                    // Ensure the element exists before updating it
                    $favoritesCount.text(data.favoritesCount);
                }
            }
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