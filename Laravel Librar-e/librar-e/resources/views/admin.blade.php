<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Admin Access</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"> -->
        
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/admin1.css')}}">
       
      </head>
    <body>
      <div class="container-fluid">
        <div class="row">
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top col-12 col-lg-2">
            <a class="navbar-brand" href="#">Librar-e</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav flex-column">
                <li class="nav-item">
                  <a class="nav-link" href="/usermanage">Manage User</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/resourcemanage">Manage Resources</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" style="cursor: pointer;" onclick="logoutConfirmation()">Logout</a>
                </li>
              </ul>
            </div>
          </nav>
          
        </div>
      </div>
      <script>
        function logoutConfirmation() {
            var result = confirm("Are you sure you want to logout?");
            if (result) {
                window.location.href = "/loginform";
            }
        }
        </script>
          <!--<script src="{% static 'js/bootstrap.min.js' %}"></script>-->
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    
        </body>
</html>