@extends('dashboard')
<head>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset ('css/landingpage.css') }}">
</head>
<body>
    <!-- Jumbotron -->
    <div class="jumbotron" style="background-image: url({{ asset('assets/img/Background.png')}}">
      <img class="lnu" src="{{ asset( 'assets/img/LNU.png') }}" alt="Description of the image">
      <p class="lead">EDUCATIONAL RESOURCE POOL</p>
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
                <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam massa velit, efficitur ac turpis in, euismod dignissim quam.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card mb-5 mb-lg-0">
              <div class="card-body">
                <h5 class="card-title">Feature 2</h5>
                <p class="card-text">Sed auctor ultrices lorem, eu lacinia mi bibendum in. In eget felis consequat, faucibus ipsum sed, efficitur libero.</p>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Feature 3</h5>
                <p class="card-text">Nam ac diam ut augue consequat vulputate at et lorem. Curabitur vitae tincidunt est. Suspendisse ut commodo dolor.</p>
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
        <div class="col-lg-4 mb-4">
          <div class="card">
            <div class="card-body">
              <p class="card-text">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae mauris eget sapien tincidunt convallis."</p>
              <p class="card-title">- John Doe</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card">
            <div class="card-body">
              <p class="card-text">"Pellentesque aliquet augue nec urna posuere, ac tristique dolor faucibus. Nulla hendrerit, mi ac pharetra fermentum, nibh nibh tristique nibh, ut sagittis elit elit a elit."</p>
              <p class="card-title">- Jane Doe</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 mb-4">
          <div class="card">
            <div class="card-body">
              <p class="card-text">"Donec aliquam mi et quam sodales, in pharetra libero suscipit. Duis ultricies consequat ligula vel elementum."</p>
              <p class="card-title">- Bob Smith</p>
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
          <p class="mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis vitae mauris eget sapien tincidunt convallis.</p>
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
          <h5>Subscribe</h5>
          <p>Join our mailing list to receive updates on new products and special promotions:</p>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Email">
            <button class="btn btn-primary" type="button">Subscribe</button>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>