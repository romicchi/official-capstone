@include('layout.usernav')

@yield('usernav')

<div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Edit Resource') }}</div>

                    <div class="card-body">
                        <form action="{{ route('resources.update', $resource) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="title">{{ __('Title') }}</label>
                                <input type="text" class="form-control" name="title" value="{{ $resource->title }}" required>
                            </div>

                            <div class="form-group">
                                <label for="author">{{ __('Author') }}</label>
                                <input type="text" class="form-control" name="author" value="{{ $resource->author }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">{{ __('Description') }}</label>
                                <textarea class="form-control" name="description" required>{{ $resource->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">{{ __('Update') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>