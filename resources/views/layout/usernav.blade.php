@section('usernav')

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/style.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset('css/usernav.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
      <div class="container-fluid">
        <div class="row">
          <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top col-12 col-lg-2">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/img/logo.png') }}" alt="Logo" class="logo-image">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
            @php
            $currentRoute = \Illuminate\Support\Facades\Request::route()->getName();
            @endphp
            <div class="collapse navbar-collapse" id="navbarNav">
              <ul class="navbar-nav flex-column">
                <li class="nav-item">
                        <a class="nav-link {{ $currentRoute === 'dashboard' ? 'active' : 'inactive' }}" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <li class="nav-item dropend">
                  <a class="nav-link dropdown-toggle {{ $currentRoute === 'show.disciplines' ? 'active' : 'inactive' }}" id="dropdown01" data-bs-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <img class="images">Resources
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown01">
                  @foreach ($colleges as $college)
                  <li class="dropdown dropdown-submenu">
                    <a class="dropdown-item dropdown-toggle" id="dropdown{{ $college->id }}" data-bs-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    {{ $college->collegeName }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="dropdown{{ $college->id }}">
                    @foreach ($college->disciplines as $discipline)
                      <li><a class="dropdown-item" href="{{ route('show.disciplines', ['college_id' => $college->id, 'discipline_id' => $discipline->id]) }}">{{ $discipline->disciplineName }}</a></li>
                    @endforeach
                </ul>
              </li>
              @endforeach
            </ul>
          </li>
                
          <li class="nav-item dropend">
          <a class="nav-link {{ in_array($currentRoute, ['journals.index', 'notes.index', 'history.index']) ? 'active personal' : 'personal' }} dropdown-toggle" id="dropdown2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

            <img>Personal
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown2">
            <a class="dropdown-item" href="{{ route('history.index') }}">View History</a>
            <a class="dropdown-item" href="{{ route('journals.index') }}">Study Journal</a>
            <a class="dropdown-item" href="{{ route ('favorites') }}">Favorites</a>
          </ul>
        </li>

                <li class="nav-item">
                  <a class="nav-link {{ $currentRoute === 'nexus.index' ? 'active' : 'inactive' }}" href="{{ route('nexus.index') }}"><img class="images1">Nexus Maps</a>
                </li>

                <li class="nav-item">
                  <a class="nav-link {{ $currentRoute === 'discussions.index' ? 'active' : 'inactive' }}" href="{{ route('discussions.index') }}"><img class="images1">Forum</a>
                </li>
                
                <!-- Button available for the teacher role only -->
                @if (auth()->user()->role_id === 2)
                <li class="nav-item">
                  <a class="nav-link {{ $currentRoute === 'teacher.manage' ? 'active' : 'inactive' }}" href="{{ route('teacher.manage') }}"><img class="images1">Uploads</a>
                </li>
                @endif

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <div class="navbar-text text-white text-center mt-4 clickable" onclick="window.location='{{ route('settings') }}';" style="cursor: pointer;">
                  <div>
                    <strong>{{ auth()->user()->firstname }}</strong>
                  </div>
                  <div>
                    {{ auth()->user()->email }}
                  </div>
                </div>

                <li class="nav-item logout">
                  <a class="nav-link" href="{{ route('logout') }}">
                    <i class="fas fa-sign-out-alt"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          </nav>
          
        </div>
      </div>

      <!-- New user guide overlay (initially hidden) -->
      <div class="new-user-guide-overlay" style="display: none;">
          <div class="new-user-guide-card">
              <div class="new-user-guide-content">
                  <h3>Welcome, New User!</h3>
                  <p id="guide-text">Here's what each navbar link does:</p>
              </div>
              <div class="new-user-guide-buttons">
                  <button id="prev-guide-button" disabled>Prev</button>
                  <button id="next-guide-button">Next</button>
                  <button id="skip-guide-button">Skip</button>
              </div>
          </div>
      </div>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
          <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
          <script>
              $(document).ready(function() {
              $('.dropdown-submenu a.dropdown-toggle').on("click", function(e) {
              $(this).next('ul').toggle();
              e.stopPropagation();
              e.preventDefault();
            });
          });



          // Variables to track guide state and current step
    let showGuide = true;
    let currentStep = 0;

    // Array of guide steps
    const guideSteps = [
        "Dashboard: Access GENER and ask anything.",
        "Resources: Access educational resources.",
        "Personal: Manage your history, study journal, and favorites.",
        "Forum: Join discussions and interact with other students & teachers.",
        @if (auth()->user()->role_id === 2)
        "Uploads: Upload educational resources and manage uploaded content.",
        @endif
        "Settings: Adjust your account settings."
    ];

// Function to update the guide content and position it next to the active navigation link
function updateGuideContent() {
    if (currentStep < guideSteps.length) {
        // Update the guide text
        document.getElementById('guide-text').textContent = guideSteps[currentStep];

        // Get the active navigation link
        const activeNavLink = document.querySelector('.nav-link.active');

        // Position the guide card next to the active navigation link
        if (activeNavLink) {
            const navLinkRect = activeNavLink.getBoundingClientRect();
            const guideCard = document.querySelector('.new-user-guide-card');
            const guideCardRect = guideCard.getBoundingClientRect();

            // Calculate the top and left positions for the guide card
            const topPosition = navLinkRect.top + window.scrollY + (navLinkRect.height / 2) - (guideCardRect.height / 2);
            const leftPosition = navLinkRect.right + window.scrollX + 20; // Adjust the spacing as needed

            guideCard.style.top = topPosition + 'px';
            guideCard.style.left = leftPosition + 'px';
        }

        // Enable or disable the "Previous" and "Next" buttons based on the current step
        document.getElementById('prev-guide-button').disabled = currentStep === 0;
        document.getElementById('next-guide-button').disabled = currentStep === guideSteps.length - 1;

        // Hide the "Previous" button on the first step
        if (currentStep === 0) {
            document.getElementById('prev-guide-button').style.display = 'none';
        } else {
            document.getElementById('prev-guide-button').style.display = 'block';
        }
        
        // Hide the guide when reaching the last step
        if (currentStep === guideSteps.length - 1) {
            hideGuide();
        }
    } else {
        // If all steps are completed, hide the guide
        hideGuide();
    }
}

    // Function to show the guide overlay
    function showGuideOverlay() {
        document.querySelector('.new-user-guide-overlay').style.display = 'block';
        updateGuideContent();
    }

// Function to hide the guide overlay and update seen_guide
function hideGuide() {
    document.querySelector('.new-user-guide-overlay').style.display = 'none';
    // Set the seen_guide flag so the guide won't appear again
    @if (auth()->user()->seen_guide === 0)
        $.ajax({
            url: '{{ route('updateSeenGuide') }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.success) {
                    console.log('seen_guide updated to 1');
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    @endif
    showGuide = false;
}

    // Event listener for the "Next" button
    document.getElementById('next-guide-button').addEventListener('click', () => {
        currentStep++;
        updateGuideContent();
    });

    // Event listener for the "Previous" button
document.getElementById('prev-guide-button').addEventListener('click', () => {
    if (currentStep > 0) {
        currentStep--;
        updateGuideContent();
    }
});

    // Event listener for the "Skip" button
    document.getElementById('skip-guide-button').addEventListener('click', () => {
        hideGuide();
    });

    // Show the guide if it's the first time for the user and change seen_guide to 1
    @if (auth()->user()->seen_guide === 0)
    showGuideOverlay();
    @endif
          </script>

@show