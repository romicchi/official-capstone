@include('layout.usernav')

@yield('usernav')

<head>
<title>@yield('title')</title>

<link rel="stylesheet" type="text/css" href="{{ asset ('css/subjects.css') }}">
</head>

<div class="container">
  <h1>@yield('subject-title')</h1> <br>

@section('searchbar')
  <div class="d-flex justify-content-end align-items-center">
    <div class="mr-3">
      <!-- Search Bar -->
      <div class="dropdown">
        <input class="form-control form-control-sm" id="myInput" type="text" placeholder="Search..">
      </div>
    </div>
  
    <div class="dropdown mr-3">
      <!-- Filter Dropdown -->
      <button class="btn btn-secondary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Filter
      </button>
      <div class="dropdown-menu" aria-labelledby="filterDropdown">
        <a class="dropdown-item" href="#">Option 1</a>
        <a class="dropdown-item" href="#">Option 2</a>
        <a class="dropdown-item" href="#">Option 3</a>
      </div>
    </div>
  
    <div class="dropdown">
      <!-- Sort Dropdown -->
      <button class="btn btn-secondary dropdown-toggle" type="button" id="sortDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Sort
      </button>
      <div class="dropdown-menu" aria-labelledby="sortDropdown">
        <a class="dropdown-item" href="#">Name</a>
        <a class="dropdown-item" href="#">Date</a>
        <a class="dropdown-item" href="#">Recent</a>
      </div>
    </div>
  </div>
@show


@section('subjects')

 <div class="row">
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="@yield('subject1-url')">
          <div class="panel cardbgcolor">
          <div class="panel-body custom-image" style="background-image: url(@yield('subject-image1', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                    <p>@yield('subject1')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image2', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject2')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image3', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject3')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image4', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject4')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image5', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject5')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image6', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject6')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image7', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject7')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image8', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject8')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image9', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject9')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image10', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject10')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image11', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject11')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url(@yield('subject-image12', asset('assets/img/Custom_image.jpg'))); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <p>@yield('subject12')</p>
                  </ul>
              </div>
          </div>
        </a>
      </div>
  </div>
</div>
@show





