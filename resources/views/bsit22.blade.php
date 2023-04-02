@extends('dashboard')

<link rel="stylesheet" type="text/css" href="{{ asset ('css/subjects.css') }}">
<div class="container">
  <h1>INFORMATION TECHNOLOGY SUBJECTS</h1> <br>

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



  <div class="row">
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="{% url 'quantitative' %}">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url({{ asset ('assets/img/Quantitative.jpg') }}); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                    <li>Quantitative Methods and Simulation</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url({{ asset ('assets/img/Arduino.jpg') }}); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <li>Arduino II</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body custom-image" style="background-image: url({{ asset ('assets/img/IAS.jpg') }}); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <li>Information Assurance and Security</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 4</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
            <div class="panel-body custom-image" style="background-image: url({{ asset ('assets/img/RIPrengoku.jpg') }}); background-size: 100% 100%;">
                  <ul class="list-unstyled center text-center">
                      <li>RIP :(</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 6</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 7</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 8</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 9</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 10</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 11</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>
      <div class="col-lg-4 col-md-4 col-6">
        <a style="text-decoration: none; color: black;" href="#">
          <div class="panel cardbgcolor">
              <div class="panel-body">
                  <ul class="list-unstyled center text-center">
                      <li>SUBJECT 12</li>
                  </ul>
              </div>
          </div>
        </a>
      </div>

  </div>
</div>
