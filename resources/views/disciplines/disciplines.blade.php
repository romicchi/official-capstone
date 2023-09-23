
@if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
    @include('layout.adminnavlayout')
@else
    @include('layout.usernav')
@endif

@section('content')
    <div class="container my-5">
        <h2 class="text-center"><strong>{{ $discipline->disciplineName }}</strong></h2>
        <h2>Resources</h2>
        <div class="mb-3">
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Resource Name</th>
                    <!-- Add more table headers if needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($discipline->resources as $resource)
                    <tr>
                        <td>{{ $resource->resourceName }}</td>
                        <!-- Add more table cells for additional resource properties -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@show

