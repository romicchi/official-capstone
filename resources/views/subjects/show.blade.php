@if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
    @include('layout.adminnavlayout')
@else
    @include('layout.usernav')
@endif

@section('content')
<div class="container" style="width: 80vw; height: 80vh;">
    <div class="content">
        <!DOCTYPE html>
        <html>
        <head>
            <title>GENER</title>
            <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.0/viewer.min.css">
            <link rel="stylesheet" type="text/css" href="{{ asset('css/embed.css') }}">
            <meta name="csrf-token" content="{{ csrf_token() }}">
        </head>
        <body>
        <div class="row">
            <div class="col-md-12">
            
                <div class="card p-4 mb-2">
                    <div class="text-center resource-info">
                        <h2 class="resource-title font-poppins-bold">{{ $resource->title }}</h2>
                        <p class="resource-author">Author: {{ $resource->author }}</p>
                    </div>
                    <p class="resource-description text-justify font-italic">{{ $resource->description }}</p>                    
                    <div class="text-center resource-info">
                        <p class="resource-keywords text-muted"><small>Keywords: {{ $resource->keywords }}</small></p>
                        <!-- rating given -->
                        @if($userRating)
                        <div class="mt-3">
                            <span class="ml-2">Your Rating: {{ $userRating->rating }}</span>
                            <span class="text-warning">
                                @for ($i = 1; $i <= $userRating->rating; $i++)
                                <i class="fas fa-star"></i>
                                @endfor
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mb-2"> <!-- Buttons in one line -->
                    <div> <!-- Left-aligned buttons -->
                        <a href="{{ route('show.disciplines', ['college_id' => $discipline->college_id, 'discipline_id' => $discipline->id]) }}" class="btn btn-primary mr-2">
                            <i class="fas fa-arrow-left">
                            </i> Back</a>
                        <button class="btn btn-success rate-resource" data-resource-id="{{ $resource->id }}" title="Rate">
                            Rate
                        </button>
                    </div>
                    <div> <!-- Right-aligned button -->
                        <a href="{{ route('resource.download', ['resource' => $resource->id]) }}" class="btn btn-primary" onclick="trackDownload({{ $resource->id }})" title="Download">
                            <i class="fas fa-download"></i>
                        </a>
                    </div>
                </div>
                        
                <div class="rating-overlay">
                    <h3>{{ $resource->title }}</h3>
                    <div class="stars-container">
                        <span class="star" data-rating="1">&#9733;</span>
                        <span class="star" data-rating="2">&#9733;</span>
                        <span class="star" data-rating="3">&#9733;</span>
                        <span class="star" data-rating="4">&#9733;</span>
                        <span class="star" data-rating="5">&#9733;</span>
                        <div class="success-message"></div>
                        <div class="error-message"></div>
                    </div>
                </div>
            
            <div class="full-width-embed shadow mb-5" id="pptx-container" style="width: 100%; height: 50rem;"> <!-- To set a fixed height for pptx-container -->
                <div id="loading-spinner" class="text-center" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <embed id="pdf-embed" src="{{ $resource->url }}" width="100%" height="100%" onload="handlePdfLoad()">
            </div>

            </div>
            <div class="col-md-12 comment-container mb-5">
                @include('subjects.comment')
                @include('subjects.comment_form')
            </div>
        </div>

        @include('layout.globalchatbot') 

        </body>
        </html>
    </div>
</div>
@show

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.0/viewer.min.js"></script>
<script>
function handlePdfLoad() {
    var pdfEmbed = document.getElementById('pdf-embed');
    var loadingSpinner = document.getElementById('loading-spinner');
    var pptxContainer = document.getElementById('pptx-container');

    pdfEmbed.style.display = 'block'; // Show the PDF embed
    loadingSpinner.style.display = 'none'; // Hide loading spinner
    pptxContainer.style.height = pdfEmbed.offsetHeight + 'px';

    // Initialize the viewer after the PDF is loaded
    var viewer = new Viewer(pptxContainer, {
        navbar: false,
        toolbar: {
            zoomIn: 1,
            zoomOut: 1,
            oneToOne: 4,
            reset: 0,
            prev: 1,
            play: 0,
            next: 1,
            rotateLeft: 0,
            rotateRight: 0,
            flipHorizontal: 0,
            flipVertical: 0
        }
    });
}

    $(document).ready(function () {
        // Handle star rating selection within the overlay
        var stars = $('.rating-overlay .star');

        stars.hover(
            function () {
                // On hover, add the 'hovered' class to stars up to the current one
                stars.slice(0, $(this).index() + 1).addClass('hovered');
            },
            function () {
                // On mouse out, remove the 'hovered' class from all stars
                stars.removeClass('hovered');
            }
        );

        // Show the rating overlay when the "Rate" link is clicked
        $('.rate-resource').click(function (e) {
            e.preventDefault(); // Prevent the link from navigating

            // Hide all other rating overlays (if any)
            $('.rating-overlay').hide();

            // Show the rating overlay for the clicked resource
            var overlay = $(this).closest('.content').find('.rating-overlay');
            overlay.fadeIn();

            // Handle star rating selection within the overlay
            overlay.find('.star').click(function () {
                var rating = $(this).data('rating');
                var resourceId = {{ $resource->id }}; // Make sure $resource->id is correctly populated

                // Send the rating data to your server using AJAX
                $.ajax({
                    url: '{{ route('resource.rate') }}',
                    type: 'POST',
                    data: {
                        resourceId: resourceId,
                        rating: rating,
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function (data) {
                        if (data.success) {
                            // Display the success message within the overlay
                            overlay.find('.success-message').html('Rating submitted successfully.');
                            // You can update the UI to reflect the new rating here if needed
                        } else {
                            // Display the error message within the overlay
                            overlay.find('.error-message').html('You have already rated this resource.');
                        }
                    },
                    error: function () {
                        // Display the error message within the overlay
                        overlay.find('.error-message').html('Failed to submit rating.');
                    },
                });

                // Hide the rating overlay after selecting a rating
                overlay.fadeOut();
            });

            // Close the rating overlay when clicking outside of it
            $(document).mouseup(function (e) {
                if (!overlay.is(e.target) && overlay.has(e.target).length === 0) {
                    overlay.fadeOut();
                }
            });
        });
        
        // ...
    });

    $(document).ready(function () {
    var commentContainer = $('.comment-container');

    commentContainer.on('click', '.pagination a', function (e) {
        e.preventDefault();

        var url = $(this).attr('href');

        $.ajax({
            url: url,
            success: function (data) {
                commentContainer.html(data);
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