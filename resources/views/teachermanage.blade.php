@include('layout.usernav')

@yield('usernav')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/table.css')}}">

    <!-- Teacher Resource Table -->
    <section class="resource-management">
  <h2>Management Resources</h2>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Add Resource</h4>
          <form>
            <div class="form-group">
              <label for="title">Title</label>
              <input type="text" class="form-control" id="title" name="title">
            </div>
            <div class="form-group">
              <label for="topic">Topic(s)</label>
              <input type="text" class="form-control" id="topic" name="topic">
            </div>
            <div class="form-group">
              <label for="keywords">Keywords</label>
              <input type="text" class="form-control" id="keywords" name="keywords">
            </div>
            <div class="form-group">
              <label for="author">Owner(s)</label>
              <input type="text" class="form-control" id="author" name="author">
            </div>
            <div class="form-group">
              <label for="description">Description/Summary</label>
              <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="form-group">
                 <label for="subject">College</label>
                 <select class="form-control" id="subject" name="subject">
                     <option value="">Select College</option>
                     @foreach ($colleges as $college)
                         <option value="{{ $college->id }}">{{ $college->collegeName }}</option>
                     @endforeach
                 </select>
             </div>
            <div class="form-group">
                 <label for="course">Course</label>
                 <select class="form-control" id="course" name="course">
                     <option value="">Select Course</option>
                     @foreach ($courses as $course)
                         <option value="{{ $course->id }}">{{ $course->subjectName }}</option>
                     @endforeach
                 </select>
             </div>
             <div class="form-group">
                 <label for="subject">Subject</label>
                 <select class="form-control" id="subject" name="subject">
                     <option value="">Select Subject</option>
                     @foreach ($subjects as $subject)
                         <option value="{{ $subject->id }}">{{ $subject->subjectName }}</option>
                     @endforeach
                 </select>
             </div>
            <div class="form-group">
              <label for="resourceType">File</label>
              <input type="file" class="form-control-file" id="resourceType" name="resourceType">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
          </form>
        </div>
      </div>
    </div>
    <div class="col-md-8">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Resource List</h4>
          <table class="table">
            <thead>
              <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Resource 1</td>
                <td>John Doe</td>
                <td>Lorem ipsum dolor sit amet</td>
                <td>
                  <a href="#" class="btn btn-primary">Edit</a>
                  <a href="#" class="btn btn-danger">Delete</a>
                </td>
              </tr>
              <tr>
                <td>Resource 2</td>
                <td>Jane Doe</td>
                <td>Consectetur adipiscing elit</td>
                <td>
                  <a href="#" class="btn btn-primary">Edit</a>
                  <a href="#" class="btn btn-danger">Delete</a>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>
