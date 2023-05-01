@include('layout.usernav')

@yield('usernav')


<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">

<div class="dropdown">
  <input class="form-control-sm" id="myInput" type="text" placeholder="Search..">
</div>

<center>

	<form class="table-responsive table-wrapper">
	<table class="table table-bordered table-hover">
		<thead>
		<tr>
			<th>Title</th>
			<th>Author</th>
			<th>Date</th>
			<th>College</th>
            <th>Course</th>
            <th>Subject</th>
			<th>Description</th>
            <th>Status</th>
			<th>Action</th>
		</tr>
		</thead>
		<tbody>
		    @foreach($resources as $resource)
			<tr>
				<td>{{ $resource->title }}</td> 
				<td>{{ $resource->author }}</td> 
				<td>{{ $resource->created_at }}</td>
                <td>{{ $resource->college->collegeName }}</td>
				<td>{{ $resource->course->courseName }}</td>
                <td>{{ $resource->subject->subjectName }}</td>
                <td>{{ $resource->description }}</td>
				<td>
            @if ($resource->resourceStatus == 1)
                <span class="badge badge-success">Approved</span>
            @else
                <span class="badge badge-warning">Pending</span>
            @endif
        </td>
        <td>
			<form action="{{ route('resources.approve', $resource->id) }}" method="POST" style="display: inline-block">
				@csrf
				@method('PUT')
				<button type="submit" class="btn btn-success">Approve</button>
			</form>
			<form action="{{ route('resources.disapprove', $resource->id) }}" method="POST" style="display: inline-block">
				@csrf
				@method('PUT')
				<button type="submit" class="btn btn-danger">Disapprove</button>
			</form>
        </td>
			</tr>
			@endforeach
		</tbody>
	</table>
	</form>
</center>



