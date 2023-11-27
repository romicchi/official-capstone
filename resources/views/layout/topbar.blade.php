<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.mi.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<style>
    .container-fluid.px-0.bg-white.shadow-sm.position-fixed.w-100 {
        margin-left: 0rem !important;
        padding-left: 0rem !important;
        left: 0;
        z-index: 100;
    }

    .dropdown-item.email {
        pointer-events: none;
        color: inherit !important;
    }

    /* To hide the arrow in the bell icon */
.notif-toggle::after {
    display: none !important;
}

/* To position the bell icon properly */
.notif-toggle .fas.fa-bell {
    position: relative;
    top: 2px; /* Adjust the vertical position as needed */
}
</style>

<div class="container-fluid px-0 bg-white shadow-sm position-fixed w-100" style="top: 0;">
    <div class="container py-3">
        <div class="row">
            <div class="col-md-6">
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end align-items-center">
                    <!-- Existing Settings and Logout Dropdown -->
                    <div class="dropdown">
                        <a href="#" class="text-decoration-none text-dark dropdown-toggle profile-toggle" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="position-relative">
                                <span class="h6 font-poppins-bold">{{ auth()->user()->firstname }}</span>
                            </span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a href="{{ route('settings') }}" class="dropdown-item">Profile Settings</a>
                            <a href="{{ route('logout') }}" class="dropdown-item">Logout</a>
                        </div>
                    </div>

                    <!-- Notifications Dropdown -->
                    <div class="dropdown ms-3">
                        <a href="#" class="text-decoration-none text-dark dropdown-toggle notif-toggle" id="notificationDropdownButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="position-relative">
                                <i class="fas fa-bell"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notificationCount">
                                    {{ auth()->user()->notifications->where('read', false)->count() }}
                                    <span class="visually-hidden">unread messages</span>
                                </span>
                            </span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="notificationDropdownButton" id="notificationsDropdown">
                            <!-- Loop through notifications and display them -->
                            @foreach(auth()->user()->notifications->where('read', false) as $notification)
                                <form action="{{ route('markAsRead', $notification) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item" onclick="redirectToDiscussion('{{ route('discussions.show', $notification->discussion_slug) }}')">
                                        <small>{{ $notification->created_at->diffForHumans() }}: </small>
                                        {{ $notification->message }}
                                    </button>
                                </form>
                            @endforeach
                            <!-- hide button if notif or read is zero -->
                            @if(auth()->user()->notifications->where('read', false)->count() > 0)
                                <form action="{{ route('markAllAsRead') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Mark All as Read</button>
                                </form>
                            @else
                            <!-- If there are no notifications -->
                                <a class="dropdown-item">No new notifications</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function redirectToDiscussion(url) {
        window.location.href = url; // Redirect to the discussion URL
    }

    $(document).ready(function() {
        $('#notificationDropdownButton').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: '{{ route('get.notifications') }}',
                method: 'GET',
                success: function(response) {
                    $('#notificationsDropdown').empty();
                    let notifications = response.notifications;
                    if (notifications.length > 0) {
                        $.each(notifications, function(index, notification) {
                            // Check if 'data' array exists before accessing its elements
                            let message = notification.data && notification.data.message ? notification.data.message : 'No message';
                            $('#notificationsDropdown').append('<a class="dropdown-item" href="#">' + message + '</a>');
                        });
                    } else {
                        $('#notificationsDropdown').append('<a class="dropdown-item" href="#">No new notifications</a>');
                    }
                    // Update notification count badge
                    $('#notificationCount').text(notifications.length);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
