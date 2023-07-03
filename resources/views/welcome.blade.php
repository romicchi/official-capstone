@include('layout.homenav')
@include('layout.chatbotlayout')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@section('title', 'GENER')</title>

        <!-- Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset ('css/landingpage.css') }}">

    </head>
    @yield('chatbot')
    <body class="antialiased">
        @section('navbar')
        @endsection
                <!-- Jumbotron -->
    <div class="jumbotron" data-aos="fade-down" style="background-image: url({{ asset('assets/img/Background.png')}}">
      <hr class="my-4">
    </div>

    <!-- Features Section -->
    <section class="features">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="card mb-5 mb-lg-0">
              <div class="card-body">
                <h5 class="card-title">Feature 1</h5>
                <p class="card-text">Provide students with easy access to information about all the courses offered at LNU.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card mb-5 mb-lg-0">
              <div class="card-body">
                <h5 class="card-title">Feature 2</h5>
                <p class="card-text">The platform enables teachers to easily share educational materials with their students, such as lecture notes, study guides, and reading assignments.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Feature 3</h5>
                <p class="card-text">Enables students to quickly find the learning resources they need. Students can search by keyword, subject, or topic to locate relevant materials.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Testimonials Section -->
<section class="testimonials">
    <div class="container">
      <h2 class="mb-5">Testimonials</h2>
      <div class="row">
        <div class="col-lg-4 mb-4" data-aos="fade-down">
          <div class="card">
            <div class="card-body" data-aos="fade-down">
              <p class="card-text">"At GENER, we believe that every LNU student deserves to succeed academically."</p>
              <p class="card-title">- Justine</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4" data-aos="fade-up">
          <div class="card">
            <div class="card-body" data-aos="fade-up">
              <p class="card-text">"Our platform is designed to offer various resources from textbooks, modules, online materials, lectures, notes, and much more."</p>
              <p class="card-title">- Challen</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4" data-aos="fade-down">
          <div class="card">
            <div class="card-body" data-aos="fade-down">
              <p class="card-text">"GENER serves as an educational resource pool specifically designed for students  LNU students by supporting their academic research and enhancing their learning experience."</p>
              <p class="card-title">- Justin</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Footer -->
  <footer class="bg-dark text-white py-3">
    <div class="container">
      <div class="row">
        <div class="col-lg-6 mb-2 mb-lg-0">
          <h5>About Us</h5>
          <p class="mb-0">{{config('app.name')}} is a Resource Pool system for LNU Students.</p>
        </div>
        <div class="col-lg-3">
          <h5>Links</h5>
          <ul class="list-unstyled">
            <li><a href="#">Home</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </div>
        <div class="col-lg-3">
          <h5>GET NOTIFIED FOR LATEST UPDATE</h5>
          <p>Subscribe to our mailing list to receive updates on new resources:</p>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Email">
            <button class="btn btn-primary" type="button">Submit</button>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-12 text-center mt-3">
          <p>&copy; 2023 Leyte Normal University. All Rights Reserved.</p>
        </div>
      </div>
    </div>
  </footer>

        </div>
    </body>
</html>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script>
  AOS.init();
</script>
