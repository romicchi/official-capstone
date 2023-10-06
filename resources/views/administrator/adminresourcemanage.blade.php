@extends('layout.adminnavlayout')

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/resourcemanage.css')}}">
</head>

<div class="card">
    <div class="card-header">
        Resource Management
    </div>
    <div class="card-body">
        <center>
            <input type="search" class="form-control rounded-0" name="query" id="searchInput" placeholder="Search resource..." aria-label="Search" aria-describedby="search-btn">

            <div class="table-wrapper py-2">
                <div class="card shadow mb-5">
                    <div class="table-responsive">
                <table class="table table-hover" id="resourceTable">
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
                                <td>{{ $resource->discipline->disciplineName }}</td>
                            <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                            <td>
                            <a href="{{ route('resource.show', $resource->id) }}">View</a> |
                            <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
                </div>
                            <!-- Pagination links -->
            <div class="d-flex justify-content-center">
                {{ $resources->onEachSide(3)->links('pagination::bootstrap-4') }}
            </div>
            </div>
        </div>
        </center>
    </div>
</div>

<script src="{{ asset('js/resourceManagesearch.js') }}"></script>
