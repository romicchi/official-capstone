
<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('css/forum.css') }}">

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.css">
@endsection

@section('Channel-Add')
<div class="col-md-4">
<a href="{{ route('discussions.create') }}" class="btn btn-info my-2 btn-style">+Add Discussion</a> 
            <div class="card">
                <div class="card-header layout-header"><strong>Channels</strong></div>
            <div class="card-body layout-body">
                <ul class="list-group">
                    @foreach($channels as $channel)
                        <li class="list-group-item">    
                            <a class="channel-a" href="{{ route('discussions.index') }}?channel={{ $channel->slug }}">
                                {{ $channel->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="card my-2">
            <div class="card-header layout-header">
                <strong>Filter & Sort Discussions</strong>
            </div>
            <div class="card-body layout-body">
                <form action="{{ route('discussions.index') }}" method="GET">
                    <div class="form-group">
                        <label for="course">Select a Course:</label>
                        <select name="course" id="course" class="form-control">
                            <option value="">All Courses</option>
                            @foreach ($courses as $course)
                            <option value="{{ $course->id }}" @if(request()->get('course') == $course->id) selected @endif>
                                {{ $course->courseName }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sort">Sort Discussions:</label>
                        <select name="sort" id="sort" class="form-control">
                            <option value="newest" @if(request()->get('sort') == 'newest') selected @endif>Newest to Oldest</option>
                            <option value="oldest" @if(request()->get('sort') == 'oldest') selected @endif>Oldest to Newest</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary my-2">Apply Filters</button>
                </form>
            </div>
        </div>
    </div>

    
@endsection


@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.js"></script>
@endsection