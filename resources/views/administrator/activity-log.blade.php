@extends('layout.adminnavlayout')

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/logs.css')}}">
</head>

<h1>Activity Log</h1>

<div class="table-container shadow">
    
     <div class="d-flex justify-content-between align-items-center">
        <!-- Filter -->
        <form action="{{ route('activity-log.filter') }}" method="GET" class="ml-3">
            <div class="input-group m-3">
                <select name="activity_filter" class="form-control">
                    <option value="">All Activities</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                    <option value="register">Register</option>
                    <option value="create">Create</option>
                    <option value="update">Update</option>
                    <option value="delete">Delete</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>

        <!-- Search -->
        <form action="{{ route('activity-log.search') }}" method="GET" class="ml-3">
            <div class="input-group">
                <input type="search" class="form-control rounded-0" name="query" id="searchInput" placeholder="Search user" aria-label="Search" aria-describedby="search-btn">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>
    
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Student Number</th>
                <th>Name</th>
                <th>Email</th>
                <th>Activity</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activityLog as $log)
            <tr>
                <td>{{ $log->student_number }}</td>
                <td>{{ $log->firstname }} {{ $log->lastname }}</td>
                <td>{{ $log->email }}</td>
                <td>{{ ucfirst($log->activity) }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <!-- pagination bootstrap center-->
    <div class="d-flex justify-content-center my-3">
    {{ $activityLog->appends(['activity_filter' => request('activity_filter'), 'query' => request('query')])->onEachSide(3)->links('pagination::bootstrap-4') }}
    </div>
</div>
