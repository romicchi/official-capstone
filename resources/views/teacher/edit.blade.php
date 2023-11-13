@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
</head>
<style>
    .card-header{
        background-color: #070372 !important;
        color: white !important;
    }
</style>

<div class="container my-5">
    
        <div class="row justify-content-center">
            <div class="col-md-8">
            <div class="alert alert-danger" id="errorMessage" style="display: none;"></div>
                <div class="card shadow">
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
                                <label for="keywords">{{ __('Keywords') }}</label>
                                <input type="text" class="form-control" name="keywords" id="keywords" value="{{ $resource->keywords }}" required>
                            </div>
                            
                            <div>  Discipline </div>
                            <select class="form-control" name="discipline_id" id="discipline_id" required>
                                <option value="" @if(empty($resource->discipline_id)) selected @endif></option>
                                @foreach($disciplines as $id => $name)
                                    <option value="{{ $id }}" @if($resource->discipline_id === $id) selected @endif>{{ $name }}</option>
                                @endforeach
                            </select>

                            <div>College</div>
                            <select class="form-control" name="college_id" id="college_id" required>
                                <option value="" @if(empty($resource->college_id)) selected @endif></option>
                                @foreach($colleges as $college)
                                <option value="{{ $college->id }}" @if($resource->college_id == $college->id) selected @endif>{{ $college->collegeName }}</option>
                                @endforeach
                            </select>
                            
                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control" id="description" name="description" required>{{ $resource->description }}</textarea>
                            </div>

                            <div class="form-group my-2">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                                <button type="button" id="autofillButton" class="btn btn-primary">Autofill</button>
                                <a href="{{ route('teacher.manage') }}" class="btn btn-danger" id="cancelButton">Delete</a>
                                <a href="{{ route('teacher.manage') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                    
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    var cancelButton = document.getElementById('cancelButton');
    var errorMessage = document.getElementById('errorMessage');
    
    cancelButton.addEventListener('click', function() {
        var resourceId = {{ $resource->id }};
        
        // Make a request to delete the resource and associated files
        fetch(`{{ route('resources.destroy', $resource) }}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
        })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                // Redirect to teacher.manage after successful deletion
                window.location.href = '{{ route('teacher.manage') }}';
            } else {
                // Display an error message if deletion fails
                errorMessage.innerText = data.error || 'Failed to delete the resource.';
                errorMessage.style.display = 'block';
                errorMessage.style.color = 'red';
            }
        })
        .catch((error) => {
            console.error('Resource deletion request failed:', error);
        });
    });
});
</script>
    <script>
    var dynamicDisciplineMapping = {
        'Computer Science': 1,
        'Mathematics': 2,
        'Natural Sciences': 3,
        'The Arts': 4,
        'Sports': 5,
        'Applied Sciences': 6,
        'Social Sciences': 7,
        'Language': 8,
        'Linguistics': 9,
        'Literature': 10,
        'Geography': 11,
        'Management': 12,
        'Philosophy': 13,
        'Psychology': 14,
        'History': 15
    };

    // Function to convert discipline name to discipline_id
    function getDisciplineId(disciplineName) {
        return dynamicDisciplineMapping[disciplineName] || null;
    }

    var dynamicCollegeMapping = {
        'CME': 1,
        'CAS': 2,
        'COE': 3
    };

    // Function to convert college name to college_id
    function getCollegeId(collegeName) {
        return dynamicCollegeMapping[collegeName] || null;
    }

    document.addEventListener('DOMContentLoaded', function() {
    var descriptionField = document.getElementById('description');
    var keywordsField = document.getElementById('keywords');
    var disciplineField = document.getElementById('discipline_id');
    var collegeField = document.getElementById('college_id');
    var errorMessage = document.getElementById('errorMessage');
    var autofillButton = document.getElementById('autofillButton');

    document.getElementById('autofillButton').addEventListener('click', function () {
    // Check if the fields are empty
    if (
        descriptionField.value.trim() === '' ||
        keywordsField.value.trim() === '' ||
        disciplineField.value.trim() === '' ||
        collegeField.value.trim() === ''
    ) {
        // Make a request to Flask for autofill
        fetch('http://192.168.1.11:5000/autofill', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ title: '{{ $resource->title }}' }),
        })
        .then((response) => response.json())
        .then((data) => {
            if (data) {
                if (data.summary) {
                    descriptionField.value = data.summary;
                }
                if (data.keywords) {
                    var keywordsString = data.keywords.join(', ');
                    keywordsField.value = keywordsString;
                }
                if (data.discipline) {
                    // Convert discipline name to discipline_id
                    var disciplineId = getDisciplineId(data.discipline);
                    disciplineField.value = disciplineId;
                }
                if (data.college) {
                    // Convert college name to college_id
                    var collegeId = getCollegeId(data.college);
                    collegeField.value = collegeId;
                }
            } else {
                errorMessage.innerText = 'Autofill data not available.';
                errorMessage.style.display = 'block';
                errorMessage.style.color = 'red';
            }
        })
        .catch((error) => {
            console.error('Autofill request failed:', error);
        });
    } else {
        errorMessage.innerText = 'Fields are not empty.';
        errorMessage.style.display = 'block';
        errorMessage.style.color = 'red';
    }
    });
});
</script>

