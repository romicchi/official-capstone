@extends('layout.adminnavlayout')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/academics.css')}}">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.css">

<div class="tab">
    <button class="tablinks" onclick="openTab(event, 'colleges')">Colleges</button>
    <button class="tablinks" onclick="openTab(event, 'courses')">Courses</button>
    <button class="tablinks" onclick="openTab(event, 'subjects')">Subjects</button>
</div>

<div id="colleges" class="tabcontent">
<a href="{{ route('academics.createCollege') }}" class="btn btn-success mt-3 mb-4">+Add College</a>
<div class="table-container">

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

<div class="table-container">
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
<div class="my-3">{{ $courses->appends(['activeTab' => 'courses'])->links('pagination::bootstrap-4', ['paginator' => $courses]) }}
</div>
</div>
</div>

<div id="subjects" class="tabcontent">
    <div class="d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ route('academics.createSubject') }}" class="btn btn-success mb-3">+Add Subject</a>
            <form action="{{ route('academics.filterSubjects') }}" method="GET" class="ml-3">
                <div class="input-group m-3">
                    <select name="course_filter" class="form-control">
                        <option value="">All Courses</option>
                        @foreach($allCourses  as $course)
                            <option value="{{ $course->id }}">{{ $course->courseName }}</option>
                        @endforeach
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            </form>
        </div>
        <form action="{{ route('academics.searchSubject') }}" method="GET">
            <div class="input-group">
                <input type="text" name="subject_search" class="form-control" placeholder="Search Subjects" autocomplete="off">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>
    </div>

<div class="table-container">
<h2>Subjects</h2>
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
                    <button type="submit" class="btn btn-danger delete-confirm">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<div class="my-3">{{ $subjects->appends(['activeTab' => 'subjects'])->links('pagination::bootstrap-4', ['paginator' => $subjects]) }}</div>
</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.20/dist/sweetalert2.min.js"></script>

<script>
    const activeTab = '{{ $activeTab ?? '' }}';


    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

        // Highlight the active tab when the page loads
        window.onload = function () {
        if (activeTab) {
            const tabButton = document.querySelector(`.tablinks[data-tab="${activeTab}"]`);
            if (tabButton) {
                tabButton.click();
            }
        }
    };


       // Function to show SweetAlert2 confirmation dialog
       function showDeleteConfirmation(callback) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                callback();
            }
        });
    }

    // Attach event listeners to delete buttons
    document.addEventListener('DOMContentLoaded', function() {
        const deleteButtons = document.querySelectorAll('.delete-confirm');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                showDeleteConfirmation(() => {
                    form.submit();
                });
            });
        });
    });
</script>