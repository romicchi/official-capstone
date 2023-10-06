@include('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Upload</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/teachermanage.css')}}">
</head>

    <!-- Teacher Resource Table -->
    <section class="resource-management">
  <h2>Resource Management</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Add Resource</h4>
          <form action="{{ route('resources.store') }}" method="POST" enctype="multipart/form-data">
          @csrf

          <div class="form-group row my-3">
                <label for="file" class="col-md-3 col-form-label text-md-right">{{ __('Choose File') }}</label>
                <div class="col-md-9">
                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required>
                    @error('file')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            
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
            
            <div class="form-group">
              <label for="discipline">Discipline</label>
              <select class="form-control" id="discipline" name="discipline" required>
                <option value="">Select Discipline</option>
              </select>
            </div>

            <div class="form-group row">
                <div class="col-md-9 offset-md-3">
                    <button type="submit" class="btn btn-primary m-4">
                        {{ __('Upload') }}
                    </button>
                </div>
            </div>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8 my-1">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Your File Uploads</h4>
                <table class="table">
                  <thead>
                    <tr>
                      <th>Title</th>
                      <th>Author</th>
                      <th>College</th>
                      <th>Discipline</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($resources) === 0)
                    <tr>
                      <td colspan="7">No uploaded material/resource.</td>
                    </tr>
                    @else
                    @foreach($resources as $resource)
                    <tr>
                      <td><strong>{{ $resource->title }}<strong></td>
                      <td>{{ $resource->author }}</td>
                      <td>{{ $resource->college->collegeName }}</td>
                      <td>{{ $resource->discipline->disciplineName }}</td>
                      <td>{{ $resource->description }}</td>
                      <td>
                        <a href="{{ route('resources.edit', $resource) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('resources.destroy', $resource) }}" method="POST" class="d-inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                    @endif
                  </tbody>
                </table>
                <div class="d-flex justify-content-center">
                  {{ $resources->links('pagination::bootstrap-4') }}
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script src="{{ asset('js/fetch.js') }}"></script>