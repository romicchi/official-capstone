@extends('layout.adminnavlayout')

<a href="{{ route('academics.createCollege') }}" class="btn btn-primary mb-3">+Add College</a>

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
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this college?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
{{ $colleges->links('pagination::bootstrap-4', ['paginator' => $colleges]) }}

<a href="{{ route('academics.createCourse') }}" class="btn btn-primary my-3 ">+Add Course</a>
<!-- Course Table -->
<h2>Courses</h2>
<div class="mb-3">
    <form action="{{ route('academics.searchCourse') }}" method="GET">
        <div class="input-group">
            <input type="text" name="course_search" class="form-control" placeholder="Search Courses" autocomplete="off">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
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
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this course?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="my-3">{{ $courses->links('pagination::bootstrap-4', ['paginator' => $courses]) }}</div>

<a href="{{ route('academics.createSubject') }}" class="btn btn-primary mb-3">+Add Subject</a>
<!-- Subject Table -->
<h2>Subjects</h2>
<div class="mb-3">
    <form action="{{ route('academics.searchSubject') }}" method="GET">
        <div class="input-group">
            <input type="text" name="subject_search" class="form-control" placeholder="Search Subjects" autocomplete="off">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
</div>
<table>
    <thead>
        <tr>
            <th>Subject Name</th>
            <th>Course</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subjects as $subject)
        <tr>
            <td>{{ $subject->subjectName }}</td>
            <td>{{ $subject->course->courseName }}</td>
            <td>
                <a href="{{ route('academics.editSubject', $subject->id) }}" class="btn btn-primary">Edit</a>
                <form action="{{ route('academics.destroySubject', $subject->id) }}" method="POST" style="display: inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this subject?')">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="my-3">{{ $subjects->links('pagination::bootstrap-4', ['paginator' => $subjects]) }}</div>
