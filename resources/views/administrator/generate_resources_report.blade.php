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
