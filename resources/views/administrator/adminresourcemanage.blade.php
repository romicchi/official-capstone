@include('layout.adminnavlayout')

@yield('adminnavbar')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">

<!-- Search Bar -->
<div class="d-flex justify-content-end my-1">
  <form class="form-inline" method="GET" action="{{ route('adminresources.search') }}">
    <div class="input-group" style="max-width: 250px;">
      <input type="search" class="form-control rounded-0" name="query" placeholder="Search user" aria-label="Search" aria-describedby="search-btn">
      <button class="btn btn-primary rounded-0" type="submit" id="search-btn">Search</button>
    </div>
  </form>
</div>

<center>

	<div class="table-responsive table-wrapper">
	<table class="table table-bordered table-hover">
		<thead>
		<tr>
			<th>Title</th>
			<th>Author</th>
			<th>Date</th>
			<th>College</th>
            <th>Course</th>
            <th>Subject</th>
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
				<td>
                    @if ($resource->resourceStatus == 1)
                    <span class="badge badge-success badge-lg" style="color: green;">Approved</span>
                    @else
                    <span class="badge badge-warning badge-lg" style="color: red;">Pending</span>
                    @endif
        </td>
        <td>
			<form action="{{ route('adminresources.approve', $resource->id) }}" method="POST" style="display: inline-block">
				@csrf
				@method('PUT')
				<button type="submit" class="btn btn-success">Approve</button>
			</form>
			<form action="{{ route('adminresources.disapprove', $resource->id) }}" method="POST" style="display: inline-block">
				@csrf
				@method('PUT')
				<button type="submit" class="btn btn-danger">Disapprove</button>
			</form>
        </td>
			</tr>
			@endforeach
		</tbody>
	</table>
</div>
	<!-- Pagination links -->
	<div class="d-flex justify-content-center">
    	{{ $resources->links('pagination::bootstrap-4') }}
	</div>
</center>



