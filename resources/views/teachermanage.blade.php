@include('layout.usernav')

@yield('usernav')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Teacher Management') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('teachermanage.upload') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="file" class="col-md-4 col-form-label text-md-right">{{ __('Choose File') }}</label>

                                <div class="col-md-6">
                                    <input id="file" type="file" class="form-control @error('file') is-invalid @enderror" name="file" required autofocus>

                                    @error('file')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Title') }}</label>

                                <div class="col-md-6">
                                    <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" required>

                                    @error('title')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="topics" class="col-md-4 col-form-label text-md-right">{{ __('Topics') }}</label>

                                <div class="col-md-6">
                                    <input id="topics" type="text" class="form-control @error('topics') is-invalid @enderror" name="topics" required>

                                    @error('topics')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="keywords" class="col-md-4 col-form-label text-md-right">{{ __('Keywords') }}</label>

                                <div class="col-md-6">
                                    <input id="keywords" type="text" class="form-control @error('keywords') is-invalid @enderror" name="keywords" required>

                                    @error('keywords')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="owners" class="col-md-4 col-form-label text-md-right">{{ __('Owners') }}</label>

                                <div class="col-md-6">
                                    <input id="owners" type="text" class="form-control @error('owners') is-invalid @enderror" name="owners" required>

                                    @error('owners')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-4 col-form-label text-md-right">{{ __('Description') }}</label>

                                <div class="col-md-6">
                                    <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" required></textarea>
                                     @error('description')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Upload') }}
                                    </button>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>{{ __('Title') }}</th>
                                        <th>{{ __('Topics') }}</th>
                                        <th>{{ __('Keywords') }}</th>
                                        <th>{{ __('Owners') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('File URL') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($files as $file)
                                        <tr>
                                            <td>{{ $file->title }}</td>
                                            <td>{{ $file->topics }}</td>
                                            <td>{{ $file->keywords }}</td>
                                            <td>{{ $file->owners }}</td>
                                            <td>{{ $file->description }}</td>
                                            <td><a href="{{ $file->url }}" target="_blank">{{ $file->url }}</a></td>
                                            <td>
                                            <form action="{{ route('file.delete', ['id' => $file->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </td>>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


