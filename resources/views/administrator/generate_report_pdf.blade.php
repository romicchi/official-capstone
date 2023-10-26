<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Report</title>
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/generatereport.css') }}">
</head>
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

    <!-- Table for Students -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Main Program/College</th>
                <th>1st year</th>
                <th>2nd year</th>
                <th>3rd year</th>
                <th>4th year</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colleges as $college)
                <tr>
                    <td>{{ $college->collegeName }}</td>
                    <td>{{ $college->users->where('role_id', 1)->where('year_level', 1)->whereBetween('created_at', [$startDate, $endDate])->count() ?? 0 }}</td>
                    <td>{{ $college->users->where('role_id', 1)->where('year_level', 2)->whereBetween('created_at', [$startDate, $endDate])->count() ?? 0 }}</td>
                    <td>{{ $college->users->where('role_id', 1)->where('year_level', 3)->whereBetween('created_at', [$startDate, $endDate])->count() ?? 0 }}</td>
                    <td>{{ $college->users->where('role_id', 1)->where('year_level', 4)->whereBetween('created_at', [$startDate, $endDate])->count() ?? 0 }}</td>
                    <td>
                        {{ 
                            $college->users->where('role_id', 1)->whereBetween('created_at', [$startDate, $endDate])->count()
                        }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td>{{ $totalFirstYear }}</td>
                <td>{{ $totalSecondYear }}</td>
                <td>{{ $totalThirdYear }}</td>
                <td>{{ $totalFourthYear }}</td>
                <td>{{ $totalAllYears }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Table for Teachers -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Main Program/College</th>
                <th>Total Teachers</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($colleges as $college)
                <tr>
                    <td>{{ $college->collegeName }}</td>
                    <td>{{ $college->users->where('role_id', 2)->whereBetween('created_at', [$startDate, $endDate])->count() ?? 0 }}</td>
                </tr>
            @endforeach
            <tr>
                <td>Total</td>
                <td>{{ $totalTeachers }}</td>
            </tr>
        </tbody>
    </table>
</body>
</html>
