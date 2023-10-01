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
                <!-- Change the input field to a date range input -->
                <div class="form-group">
                <label for="start_date">Select Start Date:</label>
                <input type="date" name="start_date" id="start_date" class="form-control">
            </div>
            <div class="form-group">
                <label for="end_date">Select End Date:</label>
                <input type="date" name="end_date" id="end_date" class="form-control">
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </form>
        
        <div class="card">
        <div class="card-header">Report Results</div>
            <div class="card-body">
        <table class="table" id="report-table">
            <thead>
                <tr>
                    <th class="th-color">Period</th>
                    <th class="th-color">Number of Users</th>
                </tr>
            </thead>
            <tbody id="report-table-body">
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
        <form action="{{ route('generate.pdf.report') }}" method="post" id="generateReportForm">
            @csrf
            <div class="form-group">
                <label for="report_period">Select Report Period:</label>
                <!-- Change the input field to a date range input -->
                <div class="form-group">
                    <label for="start_date">Select Start Date:</label>
                    <input type="date" name="start_date" id="start_date" class="form-control">
                </div>
                <div class="form-group">
                    <label for="end_date">Select End Date:</label>
                    <input type="date" name="end_date" id="end_date" class="form-control">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Generate Report</button>
        </form>
        
        <div class="card">
            <div class="card-header">Report Results</div>
            <div class="card-body" id="reportTable">
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

    <script>
        // Use jQuery to handle form submission and AJAX request
        $(document).ready(function () {
            $('#generateReportForm').submit(function (e) {
                e.preventDefault();
                let startDate = $('#start_date').val();
                let endDate = $('#end_date').val();
                
                // Send AJAX request to update the report table
                $.ajax({
                    url: "{{ route('update.report.table') }}",
                    method: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function (data) {
                        $('#reportTable').html(data);
                    }
                });
            });
        });
    </script>
@show

@show
