@include('layout.adminnavlayout')

@yield('adminnavbar')

<div class="col p-5">
  <div class="border p-3">
    <form action="{{ route('update') }}" method="POST">
      @csrf
      <h1 class="text-center mb-3">Update</h1>
      <input type="hidden" name="id" value="{{ $users->id }}">
      <div class="form-group">
        <label for="name">Name:</label>
        <input class="form-control border-0 rounded-0" type="text" name="name" value="{{ $users->name }}" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control border-0 rounded-0" type="text" name="email" value="{{ $users->email }}" required>
      </div>
      <div class="form-group">
        <label for="role">Role:</label>
        <input class="form-control border-0 rounded-0" type="text" name="role" value="{{ $users->role }}" required>
      </div>
      <button type="submit" class="btn btn-primary">Update</button>
    </form>
  </div>
</div>





