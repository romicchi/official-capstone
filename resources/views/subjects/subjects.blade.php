
@if(auth()->user()->role_id == 3)
    @include('layout.adminnavlayout')
@else
    @include('layout.usernav')
@endif

@section('content')
    <div class="container my-5">
    <h2 class="text-center"><strong>{{ $course->courseName }}</strong></h2>
        <h2>Subjects</h2>
        <div class="mb-3">
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <!-- Add more table headers if needed -->
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                    <td><a href="{{ route('show.resources', ['subject_id' => $subject->id]) }}">{{ $subject->subjectName }}</a></td>
                        <!-- Add more table cells for additional subject properties -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="{{ asset('js/subjectlivesearch.js') }}"></script>

@show
