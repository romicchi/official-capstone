<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Admin Report</title>
    <!-- Include Bootstrap CSS for styling -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <h5 class="text-center">Leyte Normal University
        <br>Tacloban City, Leyte</br>
    </h5>
    
    <!-- Display the date and time when the report was generated -->
    <p class="text-center">Report Generated: {{ now()->format('Y-m-d H:i:s') }}</p>
    
    <!-- Include the data you want to display in the report -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Role</th>
                <th>Number of Users</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportData as $role => $userCount)
                <tr>
                    <td>{{ ucfirst($role) }}</td>
                    <td>{{ $userCount }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>
