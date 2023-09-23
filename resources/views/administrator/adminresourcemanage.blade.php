@extends('layout.adminnavlayout')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset ('css/resourcemanage.css')}}">

<div class="card">
    <div class="card-header">
        Resource Management
    </div>
    <div class="card-body">
        <center>
            <input type="search" class="form-control rounded-0" name="query" id="searchInput" placeholder="Search resource..." aria-label="Search" aria-describedby="search-btn">

            <div class="table-wrapper py-2">
                <div class="card shadow mb-5">
                <table class="table table-bordered table-hover" id="resourceTable">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th>College</th>
                        <th>Discipline</th>
                        <th>URL</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @if(count($resources) === 0)
                        <tr>
                            <td colspan="9" class="text-center">No resource available</td>
                        </tr>
                    @else
                        @foreach($resources as $resource)
                            <tr>
                                <td><strong>{{ $resource->title }}<strong></td> 
                                <td>{{ $resource->author }}</td> 
                                <td>{{ \Carbon\Carbon::parse($resource->created_at)->format('F j, Y') }}</td>
                                <td>{{ $resource->college->collegeName }}</td>
                                <td>{{ $resource->course->courseName }}</td>
                                <td>{{ $resource->subject->subjectName }}</td>
                            <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                            <td>
                            <a href="{{ route('resource.show', $resource->id) }}">View</a> |
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
            <!-- Pagination links -->
            <div class="d-flex justify-content-center">
                {{ $resources->links('pagination::bootstrap-4') }}
            </div>
        </center>
    </div>
</div>

<script src="{{ asset('js/resourceManagesearch.js') }}"></script>
