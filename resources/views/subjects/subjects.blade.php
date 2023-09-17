
@if(auth()->user()->role_id == 3 || auth()->user()->role_id == 4)
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

        <div class="card shadow mb-4">
            <div class="card-body">
        <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Subject Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject)
                    <tr>
                        <td>
                            <a href="{{ route('show.resources', ['subject_id' => $subject->id]) }}">
                                {{ $subject->subjectName }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
    </div>

    <script src="{{ asset('js/subjectlivesearch.js') }}"></script>

@show
