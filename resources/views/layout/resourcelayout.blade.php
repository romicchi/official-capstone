@section('resourcelayout')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/resources.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/table.css')}}">

    <h3 class="title-subject">@yield('title')</h3>

    <!-- <div class="dropdown style">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Filter
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Option 1</a>
            <a class="dropdown-item" href="#">Option 2</a>
            <a class="dropdown-item" href="#">Option 3</a>
        </div>
    </div>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            Sort
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">Name</a>
            <a class="dropdown-item" href="#">Date</a>
            <a class="dropdown-item" href="#">Recent</a>
        </div>
    </div>

    <div class="dropdown">
        <input class="form-control" id="myInput" type="text" placeholder="Search..">
    </div>

     -->
    <br><br>
    <center>
        <form class="table-responsive table-wrapper">
            <table class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
						<th>Description</th>
                        <th>File</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($resources as $resource)
                @if ($resource->resourceStatus == 1 && $resource->college_id == 2 && $resource->course_id == 1 && $resource->subject_id == 1)
                    <tr>
                        <td><strong>{{ $resource->title }}<strong></td>
                        <td>{{ $resource->author }}</td>
						<td>{{ $resource->description }}</td>
                        <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                        <td><a class="btn btn-primary" href="/embed/{{ $resource->id }}">View</a>
                        <a class="btn btn-danger" href="{{ $resource->url }}" target="_blank">Download</a>
                    </tr>
                @endif
                @endforeach
                </tbody>
            </table>
        </form>
    </center>
@show
