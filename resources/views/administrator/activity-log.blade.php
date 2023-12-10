@extends('layout.adminnavlayout')

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/logs.css')}}">
</head>

<div class="h4 font-poppins-bold">Activity Log</div>

    
     <div class="d-flex justify-content-between align-items-center">
         <!-- Search -->
         <form action="{{ route('activity-log.search') }}" method="GET" class="ml-3">
             <div class="input-group">
                 <input type="text" class="form-control rounded-0" name="query" id="searchInput" placeholder="Student number/name" aria-label="Search" aria-describedby="search-btn" size="40">
                 <button type="submit" class="btn btn-primary">Search</button>
             </div>
         </form>

        <!-- Filter -->
        <form action="{{ route('activity-log.filter') }}" method="GET" class="ml-3">
            <div class="input-group m-3">
                <select name="activity_filter" class="form-control">
                    <option value="">All Activities</option>
                    <option value="login">Login</option>
                    <option value="logout">Logout</option>
                    <option value="register">Register</option>
                    <option value="verified">Verify</option>
                    <option value="archive">Archive</option>
                    <option value="reactivate">Reactivate</option>
                    <option value="upload">Upload</option>
                    <option value="favorite">Favorite</option>
                    <option value="download">Download</option>
                    <option value="rate">Rate</option>
                    <option value="comment">Comment</option>
                    <option value="delete">Delete</option>
                    <option value="create">Create</option>
                    <option value="update">Update</option>
                    <option value="add">Add</option>
                </select>
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </form>
    </div>
    
    <div class="table-responsive">
        <div class="card">
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Student Number</th>
                <th>Email</th>
                <th>Activity</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            @foreach($activityLog as $log)
            <tr class="font-poppins-bold">
                <td>{{ $log->firstname }} {{ $log->lastname }}</td>
                @if($log->student_number == null)
                <td>N/A</td>
                @else
                <td>{{ $log->student_number }}</td>
                @endif
                <td>{{ $log->email }}</td>
                <td>{{ ucfirst($log->activity) }}</td>
                <td>{{ $log->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

</div>
<!-- pagination bootstrap center-->
<div class="d-flex justify-content-center my-3">
{{ $activityLog->appends(['activity_filter' => request('activity_filter'), 'query' => request('query')])->onEachSide(3)->links('pagination::bootstrap-4') }}
</div>
