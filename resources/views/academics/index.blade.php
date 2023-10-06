@extends('layout.adminnavlayout')

<head>
    <meta charset="utf-8">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/academics.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">
</head>

<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'colleges')">Colleges</button>
    <button class="tablinks" onclick="openTab(event, 'courses')">Courses</button>
    <button class="tablinks" onclick="openTab(event, 'disciplines')">Disciplines</button>
</div>

<div id="colleges" class="tabcontent">
<a href="{{ route('academics.createCollege') }}" class="btn btn-success mt-3 mb-4">+Add College</a>
<div class="table-container shadow">

<!-- College Table -->
<h2>Colleges</h2>
<table>
    <thead>
        <tr>
            <th>College Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($colleges as $college)
        <tr>
            <td>{{ $college->collegeName }}</td>
            <td>
                <a href="{{ route('academics.editCollege', $college->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('academics.destroyCollege', $college->id) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="my-3">{{ $colleges->links('pagination::bootstrap-4', ['paginator' => $colleges]) }}</div>
</div>
</div>

<!-- Course Table -->
<div id="courses" class="tabcontent">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('academics.createCourse') }}" class="btn btn-success mb-3">+Add Course</a>
            <form action="{{ route('academics.filterCourses') }}" method="GET" class="ml-3">
                <div class="input-group m-3">
                    <select name="college_filter" class="form-control">
                        <option value="">All Colleges</option>
                        @foreach($colleges as $college)
                        <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
        <form action="{{ route('academics.searchCourse') }}" method="GET">
            <div class="input-group">
                <input type="text" name="course_search" class="form-control" placeholder="Search Courses" autocomplete="off">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

<div class="table-container shadow">
<h2>Courses</h2>
<table>
    <thead>
        <tr>
            <th>Course Name</th>
            <th>College</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($courses as $course)
        <tr>
            <td>{{ $course->courseName }}</td>
            <td>{{ $course->college->collegeName }}</td>
            <td>
                <a href="{{ route('academics.editCourse', $course->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('academics.destroyCourse', $course->id) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="my-3">{{ $courses->appends(['activeTab' => 'courses', 'college_filter' => request()->input('college_filter')])->onEachSide(1)->links('pagination::bootstrap-4', ['paginator' => $courses]) }}
</div>
</div>
</div>

<!-- Discipline Table -->
<div id="disciplines" class="tabcontent">
<div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('academics.createDiscipline') }}" class="btn btn-success mt-3 mb-4">+Add Discipline</a>
            <form action="{{ route('academics.filterDisciplines') }}" method="GET" class="ml-3">
                <div class="input-group m-3">
                    <select name="college_filter" class="form-control">
                        <option value="">All Colleges</option>
                        @foreach($colleges as $college)
                        <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
        <form action="{{ route('academics.searchDiscipline') }}" method="GET">
            <div class="input-group">
                <input type="text" name="discipline_search" class="form-control" placeholder="Search Disciplines" autocomplete="off">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

    <div class="table-container">
        <h2>Disciplines</h2>
        <table>
            <thead>
                <tr>
                    <th>Discipline Name</th>
                    <th>College</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($disciplines as $discipline)
                <tr>
                    <td>{{ $discipline->disciplineName }}</td>
                    <td>{{ $discipline->college->collegeName }}</td>
                    <td>
                        <a href="{{ route('academics.editDiscipline', $discipline->id) }}" class="btn btn-primary">Edit</a>
                        <form action="{{ route('academics.destroyDiscipline', $discipline->id) }}" method="POST" style="display: inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="my-3">{{ $disciplines->appends(['activeTab' => 'disciplines', 'college_filter' => request()->input('college_filter')])->links('pagination::bootstrap-4', ['paginator' => $disciplines]) }}
</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>
<script src="{{ asset('js/academics.js') }}"></script>