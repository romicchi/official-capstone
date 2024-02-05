@extends('layout.usernav')

<head>
    <meta charset="utf-8">
    <title>GENER | Feedback</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
</head>

<body>
    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="h4 font-poppins-bold">Feedback Form</div>
                <div class="card">

                    @if(session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    
                    <div class="card-body shadow">
                        <form method="POST" action="{{ route('feedback.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" id="title" name="title" maxlength="100" value="{{ old('title') }}">
                                @error('title')
                                <small _ngcontent-irw-c66 class="text-danger">* Title is required.</small>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="content">Content</label>
                                <textarea class="form-control" id="content" name="content" maxlength="1000" rows="3">{{ old('content') }}</textarea>
                                @error('content')
                                <small _ngcontent-irw-c66 class="text-danger">* Content is required.</small>
                                @enderror
                            </div>
                            
                            <div class="form-group">
                                <label for="category">Category</label>
                                <select class="form-control" id="category_id" name="category_id">
                                    <option value="">Select a category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <small _ngcontent-irw-c66 class="text-danger">* Category is required.</small>
                                @enderror
                            </div>
                            
                            <div class="form-group mb-0 my-2">
                                <div class="col-md-6 offset-sm-5">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>