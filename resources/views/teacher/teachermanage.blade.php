@include('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Upload</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/teachermanage.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
</head>

<!-- Teacher Resource Table -->
<section class="resource-management">
    <h2>Resource Management</h2>
    <div class="row">
        <div class="col-md-4">
            <div class="card shadow">
                <div class="card-body add">
                    <h4 class="card-title">Add Resource</h4>
                    <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="form-group row my-3">
                            <label for="file" class="col-md-3 col-form-label text-md-right">{{ __('Choose File') }}</label>
                            <div class="col-md-9">
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required>
                                @error('file')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" id="upload-button" class="btn btn-primary m-4">
                                    {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-8 my-1">
            <div class="row">
                <div class="col-md-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="card-title">Your File Uploads</h4>
                            <!-- Search Form -->
                            <form action="{{ route('teacher.search') }}" method="GET">
                                <div class="input-group">
                                    <input type="text" class="form-control" id="searchInput" name="search" placeholder="Search...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-primary py-2">Search</button>
                                    </div>
                                </div>
                            </form>
                            <div class="table-responsive">
                                <table class="table" id="resourceTable">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>College</th>
                                            <th>Discipline</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($resources) === 0)
                                        <tr>
                                            <td colspan="7">No resource found.</td>
                                        </tr>
                                        @else
                                        @foreach($resources as $resource)
                                        <tr>
                                            <td>
                                                <a class="hover" href="{{ route('resource.show', $resource->id) }}">
                                                    <strong>{{ Str::limit($resource->title, 35) }}</strong>
                                                </a>
                                            </td>
                                            <td>{{ $resource->author }}</td>
                                            <td>{{ optional($resource->college)->collegeName ?? 'Empty' }}</td>
                                            <td>{{ optional($resource->discipline)->disciplineName ?? 'Empty' }}</td>
                                            <td>
                                                <button class="btn btn-primary mx-1" 
                                                    onclick="window.location='{{ route('resources.edit', $resource->id) }}'"
                                                    data-bs-toggle="popover"
                                                    data-bs-trigger="hover focus"
                                                    data-placement="top"
                                                    title="Edit"
                                                    data-content="Click to edit this resource">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger delete-resource-confirm" 
                                                        data-bs-toggle="popover"
                                                        data-bs-trigger="hover focus"
                                                        data-placement="top"
                                                        title="Delete"
                                                        data-content="Click to delete this resource">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $resources->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('loader')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/sweetalert.js') }}"></script>
<script src="{{ asset('js/teacher.js') }}"></script>
<script src="{{ asset('js/resourceManagesearch.js') }}"></script>
<script>
    // Initialize Bootstrap popovers
    $(function () {
        $('[data-toggle="popover"]').popover();
    });
</script>
