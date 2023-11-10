<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Resources Report</title>
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    /* PDF Report Style */
.header {
    text-align: center;
}
.header .logo {
    display: inline-block;
    margin-left: 0;

}
.header .info {
    display: inline-block;
    vertical-align: top;
}
</style>
<body>
<div class="container">
        <!-- Header with logo and university information -->
        <div class="header">
            <div class="logo">
                <!-- Logo (encoded as base64) -->
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('assets/img/logo-lnu.png'))) }}" alt="LNU Logo" width="70" height="70">
            </div>
            <div class="info">
                <h5>
                    Leyte Normal University
                    <br>Tacloban City, Leyte</br>
                </h5>
            </div>
        </div>
    </div>
    
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
                <th>Ratings</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($resources as $resource)
                <tr>
                    <td>{{ $resource->title }}</td>
                    <td>{{ $resource->view_count }}</td>
                    <td>{{ $resource->download_count }}</td>
                    <td>{{ $resource->comments->count() }}</td>
                    <td>
                        @if ($resource->ratings)
                            {{ $resource->ratings->avg('rating') }}
                        @else
                            No ratings
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
