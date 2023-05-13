@include('layout.usernav')

@yield('usernav')

<!DOCTYPE html>
<html>
<head>
    <title>Embedded Resource</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.0/viewer.min.css">
</head>
<body>
    <h1>Embedded Resource</h1>

    <h2>Title: {{ $resource->title }}</h2>
    <p>Author: {{ $resource->author }}</p>
    <p>Description: {{ $resource->description }}</p>
    
    <div id="pptx-container">
    <iframe id="pptx-iframe" src="{{ $resource->url }}"></iframe>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/viewerjs/1.11.0/viewer.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var pptxIframe = document.getElementById('pptx-iframe');
        var pptxContainer = document.getElementById('pptx-container');

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

        pptxIframe.addEventListener('load', function () {
            pptxContainer.style.height = pptxIframe.contentWindow.document.body.scrollHeight + 'px';
        });
    });
</script>
</body>
</html>
