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
        <label for="firstname">Firstname:</label>
        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter Firstname" required>
      </div>
      <div class="form-group">
        <label for="lastname">Lastname:</label>
        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Lastname" required>
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
      <div class="form-group row">
                            <label for="id" class="col-form-label"></label>
                            <div class="col-md-9">
                                <input id="id" type="file" class="form-control @error('id') is-invalid @enderror" name="id" required autofocus>
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
      <button type="submit" class="btn btn-primary">Add User</button>
      <a href="{{route('usermanage')}}" class="btn btn-danger" style="flex: 1;">Cancel</a>
    </form>
  </div>
</div>

