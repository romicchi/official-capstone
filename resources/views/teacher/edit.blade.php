@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>

<div class="container my-5">
    
        <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="alert alert-danger" id="errorMessage" style="display: none;"></div>
                <div class="card">
                    <div class="card-header">{{ __('Edit Resource') }}</div>

                    <div class="card-body">
                        
                        <form action="{{ route('resources.update', $resource) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" class="form-control" name="title" value="{{ $resource->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="author">{{ __('Author') }}</label>
                                <input type="text" class="form-control" name="author" value="{{ $resource->author }}" required>
                            </div>

                            <div class="form-group">
                                 <label for="keywords">{{ __('Keywords') }}</label>
                                 <input type="text" class="form-control" name="keywords" value="{{ $resource->keywords }}" required>
                             </div>
                            
                             <div class="form-group">
                                 <label for="discipline">{{ __('Discipline') }}</label>
                                 <input type="text" class="form-control" name="discipline" value="{{ $resource->discipline }}" required>
                             </div>

                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control" id="description" name="description" required>{{ $resource->description }}</textarea>
                            </div>

                            <div class="form-group my-2">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                <button type="button" id="autofillButton" class="btn btn-primary">Autofill</button>
                                <a href="{{ route('teacher.manage') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
    document.getElementById('autofillButton').addEventListener('click', function () {
        var descriptionField = document.getElementById('description'); // Get the description field
        var keywordsField = document.getElementById('keywords'); // Get the keywords field
        var disciplineField = document.getElementById('discipline'); // Get the discipline field
        var errorMessage = document.getElementById('errorMessage'); // Get the error message div

        // Check if the description field is empty
        if (descriptionField.value.trim() === '') {
            // Make a request to Flask for description
            fetch('http://127.0.0.1:8080/summarize', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ title: '{{ $resource->title }}' }), // Pass the title
            })
                .then((response) => response.json())
                .then((data) => {
                    if (data.summary) {
                        // Update the description field only if it's empty
                        descriptionField.value = data.summary;
                    } else {
                        // Display an error message
                        errorMessage.innerText = 'Summary not available.';
                        errorMessage.style.display = 'block';
                        errorMessage.style.color = 'red';
                    }
                })
                .catch((error) => {
                    console.error('Description autofill request failed:', error);
                });
        }

        if (keywordsField.value.trim() === '') {
    // Make a request to Flask for keywords using the PDF URL
    fetch('http://192.168.1.16:5000/predict', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ pdf_url: pdfUrl }), // Use the fetched PDF URL
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.keywords) {
                keywordsField.value = data.keywords.join(', ');
            } else {
                errorMessage.innerText = 'Keywords not available.';
                errorMessage.style.display = 'block';
                errorMessage.style.color = 'red';
            }
        })
        .catch((error) => {
            console.error('Keywords autofill request failed:', error);
        });
    }

    if (disciplineField.value.trim() === '') {
    // Make a request to Flask for discipline using the PDF URL
    fetch('http://192.168.1.16:5000/predict', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ pdf_url: pdfUrl }), // Use the fetched PDF URL
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.discipline) {
                disciplineField.value = data.discipline;
            } else {
                errorMessage.innerText = 'Discipline not available.';
                errorMessage.style.display = 'block';
                errorMessage.style.color = 'red';
            }
        })
        .catch((error) => {
            console.error('Discipline autofill request failed:', error);
        });
    }

        // Display an error message if any of the fields are not empty
        if (
            descriptionField.value.trim() !== '' ||
            keywordsField.value.trim() !== '' ||
            disciplineField.value.trim() !== ''
        ) {
            errorMessage.innerText = 'Fields are not empty.';
            errorMessage.style.display = 'block';
            errorMessage.style.color = 'red';
        }
    });
</script>
