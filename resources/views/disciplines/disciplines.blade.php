
@if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
    @include('layout.adminnavlayout')
@else
    @include('layout.usernav')
@endif

<head>
    <meta charset="utf-8">
    <title>GENER</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/resources.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
<head>
        
@section('content')
    <div class="container my-5">
        <h2 class="text-center"><strong>{{ $discipline->disciplineName }}</strong></h2>
        <div class="mb-3">
        </div>

        <div class="d-flex justify-content-between align-items-center">
    <!-- Sort -->
    <form action="{{ route('disciplines.sort', ['college_id' => $college->id, 'discipline_id' => $discipline->id]) }}" method="GET" class="mr-3">
        <div class="input-group">
            <select class="form-control" name="sort" id="sort">
                <option value="title" {{ request('sort') === 'title' ? 'selected' : '' }}>Title</option>
                <option value="author" {{ request('sort') === 'author' ? 'selected' : '' }}>Author</option>
                <option value="created_at" {{ request('sort') === 'created_at' ? 'selected' : '' }}>Date</option>
            </select>
            <button type="submit" class="btn btn-primary">Sort</button>
        </div>
    </form>
    <!-- Search -->
    <form action="{{ route('disciplines.search', ['college_id' => $college->id, 'discipline_id' => $discipline->id]) }}" method="GET" class="mr-3">
        <div class="input-group">
            <input type="search" class="form-control rounded-0" name="query" id="searchInput" placeholder="Search..." aria-label="Search" aria-describedby="search-btn" autocomplete="off" value="{{ request('query') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>


        <div class="card">
        <div class="card-body">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Date</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($resources as $resource)
                        <tr>
                            <td>
                            <a class="hover" href="{{ route('resource.show', $resource->id) }}">{{ Str::limit($resource->title, 50) }}</a>
                            </td>
                            <td>{{ $resource->author }}</td>
                            <td>
                                <!-- created_at in Oct 25, 2023 format -->
                                {{ \Carbon\Carbon::parse($resource->created_at)->format('M d, Y') }}
                            </td>
                            <td>
                            <div class="d-flex justify-content-end">
                                <button class="toggle-favorite" data-resource-id="{{ $resource->id }}">
                                    <i class="{{ auth()->user()->favorites->contains($resource) ? 'fas' : 'far' }} fa-star"></i>
                                </button>
                            </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- pagination -->
            <div class="d-flex justify-content-center my-3">
                {{ $resources->appends(['sort' => request('sort'), 'query' => request('query')])->onEachSide(3)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@show

<script>
// toggle favorite
    $(document).ready(function () {
        $('.toggle-favorite').click(function () {
            var resourceId = $(this).data('resource-id');
            var $starIcon = $(this).find('i');

            // Add the CSRF token to the data
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '{{ route('resource.toggleFavorite') }}',
                type: 'POST',
                data: { resourceId: resourceId, _token: csrfToken },
                success: function (data) {
                    // Toggle the star icon
                    $starIcon.toggleClass('fas far');

                    // Update the number of favorites in the view
                    var $favoritesCount = $('.favorites-count');
                    if ($starIcon.hasClass('fas')) {
                        $favoritesCount.text(parseInt($favoritesCount.text()) + 1);
                    } else {
                        $favoritesCount.text(parseInt($favoritesCount.text()) - 1);
                    }
                }
            });
        });
    });
</script>

