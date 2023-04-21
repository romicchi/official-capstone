@include('layout.usernav')

<head>
<link rel="stylesheet" type="text/css" href="{{ asset ('css/teacher.css') }}">
</head>

<body>
@yield('usernav')
    <center>
      <br><br><br>
      <div class="container">
        <div class="containerbg">
          <!---- Enter your codes here --->
          <br>
          <h3 style="text-align: center; font-weight: bold; font-family: Arial;">Upload Educational Resources</h3>
          <br>
          <div class="row">
            <div class="col-6 col-sm-4"><h6 style="font-weight: bold;">Course:</h6></div>
            <div class="col-6 col-sm-6"><h6 style="font-weight: bold;">Subject:</h6></div>
          </div>
          <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdown-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 25vw;">
              <font color="gray" style="font-weight: bold; font-family: Arial;">
                Select
              </font>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdown-menu">
              <a class="dropdown-item" href="#">Option 1</a>
              <a class="dropdown-item" href="#">Option 2</a>
              <a class="dropdown-item" href="#">Option 3</a>
            </div>
          </div>
          <div class="dropdown">
            <button class="btn btn-light dropdown-toggle" type="button" id="dropdown-menu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="width: 25vw;">
              <font color="gray" style="font-weight: bold; font-family: Arial;">
                Select
              </font>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdown-menu">
              <a class="dropdown-item" href="#">Name</a>
              <a class="dropdown-item" href="#">Date</a>
              <a class="dropdown-item" href="#">Recent</a>
            </div>
          </div>
          <br><br>
          <div class="row align-items-center">
            <div class="col-md-4">
              <h6 class="mb-0" style="font-weight: bold;">Link:</h6>
            </div>
            <div class="col-md-4">
              <div class="form-group">
                <input type="text" class="form-control" id="input" placeholder="Paste">
              </div>
            </div>
          </div>
          <br>
          <div class="overflow-auto card">
            <form action="/file-upload" class="form-control dropzone dz-clickable" id="dropzone">
              <div class="dz-default dz-message">
                <br><br><br><br><br>
                <h6 style="font-weight: bold;">Drag or upload your file here</h6>
                <button class="dz-button" type="button">
                  <font color="gray" style="font-weight: bold; font-family: Arial;">
                    Open file
                  </font>
                </button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </center>
</body>



