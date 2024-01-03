<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/recommendation.css')}}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@section('content')
    <div class="container">
        <div class="h3 font-poppins-bold">Relevant Resources</div>
        <table class="table shadow">
        <thead>
        <tr>
            <th class="thead">Resource</th>
            <th class="thead">Keywords</th>
            <th class="thead">Description/Summary</th>
        </tr>
    </thead>
        <tbody>
        @forelse ($resources as $resource)
                <tr>
                    <td>
                        <h4>
                            <div class="title-with-heart">
                                <button class="toggle-favorite" data-resource-id="{{ $resource->id }}">
                                    <i class="{{ auth()->user()->favorites->contains($resource) ? 'fas fa-heart' : 'far fa-heart' }}"></i>
                                </button>
                                <span class="add-to-favorites-hint">(Add to Favorites)</span>
                            </div>
                            <a class="title font-poppins-bold" href="{{ url('resource/show', $resource->id) }}">{{ $resource->title }}</a>
                        </h4>
                        <p><strong>Author:</strong> {{ $resource->author ?? 'Not Specified' }}</p>
                        <p><strong>Publish Date:</strong> {{ $resource->publish_date && strtotime($resource->publish_date) ? date('M. d, Y', strtotime($resource->publish_date)) : 'Not Specified' }}</p>
                        <p><strong>Type:</strong> {{ optional($resource->resourceType)->type ?? 'Not Specified' }}</p>
                        <p><strong>Discipline:</strong> {{ $resource->college->collegeName }} > {{ $resource->discipline->disciplineName}}</p>
                    </td>
                    <td class="justified-text">{{ Str::limit($resource->keywords,200) }}</td>
                    <td class="justified-text">{{ Str::limit($resource->description, 200) }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" style="text-align: center; vertical-align: middle;"><i>No Available Related Resource</i></td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div id="toggleFavorite" data-toggle-favorite="{{ route('resource.toggleFavorite') }}"></div>
@show

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/recommendation.js') }}"></script>
