
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/forum.css') }}">
</head>

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.css">
@endsection

@section('Channel-Add')
<div class="col-md-12">
    <div class="card mb-3">
        <div class="card-header h4 font-poppins-bold">Discussion</div>
        <div class="card-body header">
            <!-- Channels -->
            <div class="mb-3">
                <form action="{{ route('discussions.index') }}" method="GET">
                    <div class="form-group d-flex justify-content-center">
                        <label class="hide-label-xs">Select a Channel:</label>
                        <select name="channel" id="channel" class="form-control">
                            <option value="">All Channels</option>
                            @foreach($channels as $channel)
                                <option value="{{ $channel->slug }}" @if(request()->get('channel') == $channel->slug) selected @endif>
                                    {{ $channel->name }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-primary ml-2">Apply</button>
                    </div>
                </form>
            </div>

             <!-- Filter & Sort Discussions -->
             <form action="{{ route('discussions.index') }}" method="GET">
                <div class="form-group d-flex justify-content-center">
                    <label class="hide-label-xs">Select Course:</label>
                    <select name="course" id="course" class="form-control select-height">
                        <option value="">All Courses</option>
                        @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @if(request()->get('course') == $course->id) selected @endif>
                                {{ $course->courseName }}
                            </option>
                        @endforeach
                    </select>

                    <label class="hide-label-xs ml-3">Sort Discussions:</label>
                    <select name="sort" id="sort" class="form-control select-height mr-2">
                        <option value="newest" @if(request()->get('sort') == 'newest') selected @endif>Newest to Oldest</option>
                        <option value="oldest" @if(request()->get('sort') == 'oldest') selected @endif>Oldest to Newest</option>
                    </select>

                    <button type="submit" class="btn btn-primary">Apply</button>
                </div>
            </form>

            <!-- Add Button -->
                <a href="{{ route('discussions.create') }}" class="btn btn-info text-right" title="Create Discussion">+</a>
        </div>
    </div>
</div>
@endsection


@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.js"></script>
@endsection