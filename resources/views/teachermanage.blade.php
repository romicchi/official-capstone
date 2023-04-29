@include('layout.usernav')

@yield('usernav')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Teacher Management</div>

                <div class="card-body">
                    <!-- Upload file form -->
                    <form action="{{ route('upload.file') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="file">Upload Image/Video:</label>
                            <input type="file" class="form-control-file" id="file" name="file" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </form>
                    <br>

                    <!-- Metadata input form -->
                    <form action="{{ route('save.metadata') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject" required>
                        </div>
                        <div class="form-group">
                            <label for="about">About:</label>
                            <textarea class="form-control" id="about" name="about" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Save Metadata</button>
                    </form>
                    <hr>

                    <!-- Table to display metadata and preview -->
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>About</th>
                                <th>Preview</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($files as $file)
                                <tr>
                                    <td>{{ $file->name }}</td>
                                    <td>{{ $file->subject }}</td>
                                    <td>{{ $file->about }}</td>
                                    <td>
                                        @if ($file->type == 'image')
                                            <img src="{{ $file->url }}" alt="{{ $file->name }}" style="max-height: 50px; max-width: 50px;">
                                        @else
                                            <video width="50" height="50" controls>
                                                <source src="{{ $file->url }}" type="video/mp4">
                                                Your browser does not support the video tag.
                                            </video>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="{{ route('delete.file', $file->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
