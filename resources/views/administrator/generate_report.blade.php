@extends('layout.adminnavlayout')

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
</head>
<style>
    .card-body {
        height: 75rem;
    }

    .th-color {
        /* font color black */
        color: black;
    }
</style>

@section('content')
    <div class="container">
        <h1>Generate Report</h1>
        <form action="{{ route('generate.pdf.report') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="report_period">Select Report Period:</label>
                <select name="report_period" id="report_period" class="form-control">
                    <option value="day">Day</option>
                    <option value="month">Month</option>
                    <option value="year">Year</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </form>
        
        <div class="card">
            <div class="card-body">
        <h2>Report Results</h2>
        <table class="table">
            <thead>
                <tr>
                    <th class="th-color">Period</th>
                    <th class="th-color">Number of Users</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reportData as $period => $userCount)
                    <tr>
                        <td>{{ $period }}</td>
                        <td>{{ $userCount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>
@show
