@extends('layout.adminnavlayout')

<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/generatereport.css') }}">
</head>

@section('content')
<div class="container">
    <h1 class="text-center">Generate Report</h1>
    <form action="{{ route('generate.pdf.report') }}" method="post" id="generateReportForm" class="styled-form">
    @csrf
    <div class="form-group">
        <label for="report_type">Select Report Type:</label>
        <select name="report_type" id="report_type" class="form-control">
            <option value="" selected disabled>Select</option>
            <option value="user">User Report</option>
            <option value="resources">Resources Report</option>
            <option value="resources_specific">Resources Report (Specific)</option>
        </select>
    </div>
    <input type="hidden" name="selected_resource_type" id="selected_resource_type">
    <div class="form-group" id="resource_type_section" style="display: none;">
        <label for="resource_type">Select Resource Type:</label>
        <select name="resource_type" id="resource_type" class="form-control">
            <option value="" selected disabled>Select</option>
            <option value="text_based">Text-Based</option>
            <option value="video_based">Video-Based</option>
            <option value="image_based">Image-Based</option>
        </select>
    </div>
    <div class="form-group">
        <label for="report_period">Select Report Period:</label>
        <div class="form-group">
            <label for="start_date">Select Start Date:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="end_date">Select End Date:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Generate Report</button>
</form>


    <div class="card">
        <div class="card-header">Report Results</div>
        <div class="card-body">
            <table class="table" id="report-table">
                <thead>
                </thead>
                <tbody id="report-table-body">
                    <!-- Initially, the table body is empty -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Function to update the report table
    function updateReportTable() {
        let startDate = $('#start_date').val();
        let endDate = $('#end_date').val();
        let selectedReportType = $('#report_type').val(); // Get the selected report type correctly

        // Check if the selected report type is "Resources Report (Specific)"
        if (selectedReportType === 'resources_specific') {
            // Show the resource type dropdown
            $('#resource_type_section').show();
        } else {
            // Hide the resource type dropdown for other report types
            $('#resource_type_section').hide();
        }

        // Send AJAX request to update the report table based on the selected report type
        $.ajax({
            url: "{{ route('update.report.table') }}",
            method: 'POST',
            data: {
                _token: "{{ csrf_token() }}",
                start_date: startDate,
                end_date: endDate,
                report_type: selectedReportType,
                selected_resource_type: $('#selected_resource_type').val()
            },
            success: function (data) {
                $('#report-table tbody').html(data);
            },
            error: function (error) {
                console.error('Error occurred:', error);
                console.log(error);
            }
        });
    }

    // Use jQuery to handle form input changes and trigger the updateReportTable function
    $(document).ready(function () {
        $('#generateReportForm').find('select, input').on('change', function () {
            updateReportTable();
        });

        // Initial table update when the page loads
        updateReportTable();
    });

    // Selected Resource Type Read
    $(document).ready(function () {
        $('#resource_type').change(function () {
            var selectedResourceType = $(this).val();
            $('#selected_resource_type').val(selectedResourceType);
        });
    });

        // Function to update the selected resource type
        function updateSelectedResourceType() {
        var selectedResourceType = $('#resource_type').val(); // Get the selected resource type
        $('#selectedResourceType').text('Resource Type: ' + selectedResourceType);
    }

    // Listen for changes in the select element
    $(document).ready(function () {
        $('#resource_type').change(function () {
            updateSelectedResourceType(); // Call the function to update the resource type
        });
    });
</script>
@show
