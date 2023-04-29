@include('layout.usernav')

@yield('usernav')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">

<center>

	<form class="table-responsive table-wrapper">
	<table class="table table-bordered table-hover">
		<thead>
		<tr>
			<th>Title</th>
			<th>Author</th>
			<th>Date</th>
            <th>Course</th>
            <th>Subject</th>
			<th>Description</th>
            <th>Status</th>
		</tr>
		</thead>
		<tbody>
			<!-- If empty this message will display -->
			<!-- <tr>
			<td colspan="6"><strong>No departmentchairs inside the table</strong></td>
			</tr>       -->
			<tr>
				<td></td> 
				<td></td>
                <td></td>
				<td></td>
                <td></td>
                <td></td>
				<td><select class="form-control" id="status" name="status">
          <option value="student">Pending</option>
          <option value="teacher">Approve</option>
          <option value="teacher">Disapproved</option>
        </select></td>
			</tr>
		</tbody>
	</table>
	</form>
</center>


