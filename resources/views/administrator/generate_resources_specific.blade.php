<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resources Report</title>
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <h5 class="text-center">Leyte Normal University
        <br>Tacloban City, Leyte</br>
    </h5>
    
    <!-- Display the date and time when the report was generated -->
    <p class="text-center">Report Generated: {{ now()->format('Y-m-d H:i:s') }}</p>
    <p class="text-center">Start Date: {{ $startDate }}</p>
    <p class="text-center">End Date: {{ $endDate }}</p>

    <p class="text-center">Selected Resource Type: {{ $selectedResourceType }}</p>
    

    <!-- Table for Resources Report -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Views</th>
                <th>Downloads</th>
                <th>Comments</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resources as $resource)
                <tr>
                    <td>{{ $resource->title }}</td>
                    <td>{{ $resource->view_count }}</td>
                    <td>{{ $resource->download_count }}</td>
                    <td>{{ $resource->comments->count() }}</td>
                </tr>
            @endforeach
            <pre>
    Selected Resource Type: {{ $selectedResourceType }}
    Resources:
    {{ print_r($resources, true) }}
</pre>

        </tbody>
    </table>
</body>
</html>
