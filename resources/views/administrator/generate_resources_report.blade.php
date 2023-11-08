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

    <!-- Table for Resources Report -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Main Program/College</th>
                <th>Total Resources</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colleges as $college)
                <tr>
                    <td>{{ $college->collegeName }}</td>
                    <td>{{ $college->resources->whereBetween('created_at', [$startDate, $endDate])->count() ?? 0 }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td>{{ $colleges->sum(function ($college) use ($startDate, $endDate) { 
                    return $college->resources->whereBetween('created_at', [$startDate, $endDate])->count(); 
                }) }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
