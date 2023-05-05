@section('resourcelayout')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/resources.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/table.css')}}">

    <h3 class="title-subject">@yield('title')</h3>

    <div class="dropdown style">
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
					@foreach($resources as $resource)
                    <tr>
                        <td>{{ $resource->title }}</td>
                        <td>{{ $resource->author }}</td>
						<td>{{ $resource->description }}</td>
						<td></td>
                        <td><a type="submit" class="btn btn-primary" href="">View</a>
                        <a type="submit" class="btn btn-danger" href="">Download</a></td>
                    </tr>
					@endforeach
                </tbody>
            </table>
        </form>
    </center>
@show
