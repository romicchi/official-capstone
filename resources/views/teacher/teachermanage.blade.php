@include('layout.usernav')

@yield('usernav')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">

    <!-- Teacher Resource Table -->
<section class="resource-management">
  <h2>Management Resources</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Add Resource</h4>
          <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="form-group">
              <label for="topic">Topic(s)</label>
              <input type="text" class="form-control" id="topic" name="topic" required>
            </div>
            <div class="form-group">
              <label for="keywords">Keywords</label>
              <input type="text" class="form-control" id="keywords" name="keywords" required>
            </div>
            <div class="form-group">
              <label for="author">Owner(s)</label>
              <input type="text" class="form-control" id="author" name="author" required>
            </div>
            <div class="form-group">
              <label for="description">Description/Summary</label>
              <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            <div class="form-group">
              <label for="college">College</label>
              <select class="form-control" id="college" name="college" required>
                <option value="">Select College</option>
                @foreach ($colleges as $college)
                <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                @endforeach
              </select>
            </div>
            
            <div class="form-group" id="courseContainer" style="display: none;">
              <label for="course">Course</label>
              <select class="form-control" id="courseSelect" name="course" required>
                <option value="">Select Course</option>
              </select>
            </div>
            
            <div class="form-group" id="subjectContainer" style="display: none;">
              <label for="subject">Subject</label>
              <select class="form-control" id="subjectSelect" name="subject" required>
                <option value="">Select Subject</option>
              </select>
            </div>

            <div class="form-group row">
                            <label for="file" class="col-md-3 col-form-label text-md-right">{{ __('Choose File') }}</label>
                            <div class="col-md-9">
                                <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required autofocus>
                                @error('file')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
           
                        <div class="form-group row mb-0">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Upload') }}
                                </button>
                            </div>
                        </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Pending Resources</h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Author</th>
                      <th>College</th>
                      <th>Course</th>
                      <th>Subject</th>
                      <th>Description</th>
                      <th>URL</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($resources as $resource)
                    @if ($resource->resourceStatus == '0')
                    <tr>
                      <td><strong>{{ $resource->title }}<strong></td>
                      <td>{{ $resource->author }}</td>
                      <td>{{ $resource->college->collegeName }}</td>
                      <td>{{ $resource->course->courseName }}</td>
                      <td>{{ $resource->subject->subjectName }}</td>
                      <td>{{ $resource->description }}</td>
                      <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                      <td>
                        @if ($resource->resourceStatus == 1)
                        <span class="badge badge-success badge-lg" style="color: green;">Approved</span>
                        @else
                        <span class="badge badge-warning badge-lg" style="color: red;">Pending</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('resources.edit', $resource) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Verified Resources</h4>
              <div class="table-responsive">
                <table class="table">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Author</th>
                      <th>Description</th>
                      <th>URL</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($resources as $resource)
                    @if ($resource->resourceStatus == '1')
                    <tr>
                      <td><strong>{{ $resource->title }}<strong></td>
                      <td>{{ $resource->author }}</td>
                      <td>{{ $resource->description }}</td>
                      <td><a href="{{ $resource->url }}" target="_blank">{{ Str::limit($resource->url, 30) }}</a></td>
                      <td>
                        @if ($resource->resourceStatus == 1)
                        <span class="badge badge-success badge-lg" style="color: green;">Approved</span>
                        @else
                        <span class="badge badge-warning badge-lg" style="color: red;">Pending</span>
                        @endif
                      </td>
                      <td>
                        <a href="{{ route('resources.edit', $resource) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                    @endif
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('js/fetch.js') }}"></script>

 