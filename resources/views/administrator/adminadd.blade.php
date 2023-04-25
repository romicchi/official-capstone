@include('layout.adminnavlayout')

@yield('adminnavbar')

	<title>Add User</title>
	<link rel="stylesheet" type="text/css" href="{{ asset ('css/register.css') }}">

<div class="container">
  <div class="col">
    <form action="{{ route('add.user') }}" method="post" enctype="multipart/form-data">
      @csrf
      
      <!-- Error Message -->
      @if($errors->any())
        <div class="col-12">
            @foreach($errors->all() as $error)
              <div class="alert alert-danger">{{ $error }}</div>
            @endforeach
        </div>
      @endif

    <!-- Session Error -->
      @if(session()->has('error'))
        <div class="alert alert-danger">{{session('error')}}</div>
      @endif

      <!-- Success Message -->
      @if(session()->has('success'))
        <div class="alert alert-success">{{session('success')}}</div>
      @endif

      
    <h1>Add User</h1>
      <div class="form-group">
        <label for="username">Username:</label>
        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Username" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email" required>
      </div>
      <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
      </div>
      <div class="form-group">
        <label for="role">Role of the user:</label>
        <select class="form-control" id="role" name="role">
			<option value="student">Student</option>
			<option value="teacher">Teacher</option>
			<option value="programcoordinator">Program Coordinator</option>
			<option value="departmentchair">Department Chair</option>
            <option value="admin">Admin</option>
        </select>
      </div>
      <div class="form-group">
        <label for="school_id">School ID:</label>
        <input type="file" class="form-control-file" id="school_id" name="school_id" accept="image/*" required>
      </div>
      <button type="submit" class="btn btn-primary">Add User</button>
      <a href="{{route('usermanage')}}" class="btn btn-danger" style="flex: 1;">Cancel</a>
    </form>
  </div>
</div>

