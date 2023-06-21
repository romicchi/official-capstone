@include('layout.adminnavlayout')

@yield('adminnavbar')

<div class="col p-5">
  <div class="border p-3">
    <form action="{{ route('update') }}" method="POST">
      @csrf
      <h1 class="text-center mb-3">Update</h1>
      <input type="hidden" name="id" value="{{ $users->id }}">
      <div class="form-group">
        <label for="name">Firstname:</label>
        <input class="form-control border-0 rounded-0" type="text" name="firstname" value="{{ $users->firstname }}" required>
      </div>
      <div class="form-group">
        <label for="name">Lastname:</label>
        <input class="form-control border-0 rounded-0" type="text" name="lastname" value="{{ $users->lastname }}" required>
      </div>
      <div class="form-group">
        <label for="email">Email:</label>
        <input class="form-control border-0 rounded-0" type="text" name="email" value="{{ $users->email }}" required>
      </div>
      <div class="form-group">
    <label for="role">Role of the user:</label>
    <select class="form-control" id="role" name="role">
        <option value="1" {{ $users->role_id == 1 ? 'selected' : '' }}>Student</option>
        <option value="2" {{ $users->role_id == 2 ? 'selected' : '' }}>Teacher</option>
        <option value="3" {{ $users->role_id == 3 ? 'selected' : '' }}>Admin</option>
    </select>
</div>
      <div style="display: flex;">
        <button type="submit" class="btn btn-primary" style="flex: 1;">Update</button>
        <a href="{{route('usermanage')}}" class="btn btn-danger" style="flex: 1;">Cancel</a>
      </div>
    </form>
  </div>
</div>





