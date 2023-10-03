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
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.0/viewer.min.css">
        </head>
        <body>
        <div class="row">
            <div class="col-md-8">

            <div class="text-center">
            <h2>Title: {{ $resource->title }}</h2>
            <p>Author: {{ $resource->author }}</p>
            </div>
            <p>Description: {{ $resource->description }}</p>
            
            <div id="loading-spinner" class="text-center" style="width: 100%; height: 100%; display: flex; justify-content: center; align-items: center;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div id="pptx-container" style="width: 100%; height: 50rem;"> <!-- Set a fixed height for pptx-container -->
            <embed id="pdf-embed" src="{{ $resource->url }}" width="100%" height="100%" onload="handlePdfLoad()">
        </div>

            </div>
            <div class="col-md-4">
                @include('subjects.comment')
                @include('subjects.comment_form')
            </div>
        </div>
                
        </body>
        </html>
    </div>
</div>
@show

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
</script>