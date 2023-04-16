
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/forum.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css') }}">

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.css">
@endsection

@section('Channel-Add')
<div class="col-md-4">
<a href="{{ route('discussions.create') }}" class="btn btn-info my-2 btn-style">Add Discussion</a> 
            <div class="card">
                <div class="card-header"><strong>Filter By Channels</strong></div>
            <div class="card-body">
                <ul class="list-group">
                    @foreach($channels as $channel)
                        <li class="list-group-item">    
                            <a href="{{ route('discussions.index') }}?channel={{ $channel->slug }}">
                                {{ $channel->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection


@section('js')
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/trix/1.0.0/trix.js"></script>
@endsection