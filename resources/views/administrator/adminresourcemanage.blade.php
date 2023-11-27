@extends('layout.adminnavlayout')

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/resourcemanage.css') }}">
</head>

<div class="h4 font-poppins-bold">
    Resource Management
</div>
<div class="card">
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
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($resources) === 0)
                                    <tr>
                                        <td colspan="6" class="text-center">No resource available</td>
                                    </tr>
                                @else
                                    @foreach($resources as $resource)
                                        <tr class="font-poppins-bold">
                                            <td>
                                                <a class="hover font-poppins-bold" href="{{ route('resource.show', $resource->id) }}">
                                                    {{ Str::limit($resource->title, 35) }}
                                                </a>
                                            </td> 
                                            <td>{{ $resource->author }}</td> 
                                            <td>{{ \Carbon\Carbon::parse($resource->created_at)->format('F j, Y') }}</td>
                                            <td>{{ optional($resource->college)->collegeName ?? 'Empty' }}</td>
                                            <td>{{ optional($resource->discipline)->disciplineName ?? 'Empty' }}</td>
                                            <td>
                                                <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn delete-resource-confirm" title="Delete">
                                                        <i class="fas fa-trash-alt p-1"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Pagination links -->
                <div class="d-flex justify-content-center my-3">
                    {{ $resources->onEachSide(3)->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </center>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/resourceManagesearch.js') }}"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
