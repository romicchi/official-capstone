@extends('layout.usernav')
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>GENER | Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
            <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
    <div class="container">
           <!-- Content Row -->
    <div class="row justify-content-center mt-4">
        <!-- only teacher can view card Uploads -->
        @if(auth()->user()->role_id == 2)
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
            <!-- card -->
            <div class="card h-100 card-lift">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <h4 class="mb-0">Uploads</h4>
                        </div>
                        <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                            <i  data-feather="briefcase" height="20" width="20"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div class="lh-1">
                        <h1 class="mb-1 font-poppins-bold">
                            {{ $uploads }}
                        </h1>
                        <!-- <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p> -->
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
            <!-- card -->
            <div class="card h-100 card-lift">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                    mb-3">
                    <div>
                        <h4 class="mb-0">Journal</h4>
                    </div>
                    <div class="icon-shape icon-md bg-primary-soft text-primary
                    rounded-2">
                    <i  data-feather="list" height="20" width="20"></i>
                </div>
            </div>
            <!-- project number -->
            <div class="lh-1">
                <h1 class="mb-1 font-poppins-bold">
                    {{ $journals }}
                </h1>
                <!-- <p class="mb-0"><span class="text-dark me-2">28</span>Completed</p> -->
            </div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
    <!-- card -->
    <div class="card h-100 card-lift">
        <!-- card body -->
        <div class="card-body">
            <!-- heading -->
            <div class="d-flex justify-content-between align-items-center
            mb-3">
            <div>
                <h4 class="mb-0">Favorites</h4>
            </div>
            <div class="icon-shape icon-md bg-primary-soft text-primary
            rounded-2">
            <i  data-feather="users" height="20" width="20"></i>
        </div>
    </div>
    <!-- project number -->
    <div class="lh-1">
        <h1 class="mb-1 font-poppins-bold">
            {{ $favorites }}
        </h1>
        <!-- <p class="mb-0"><span class="text-dark me-2">1</span>Completed</p> -->
    </div>
</div>
</div>
</div>

<div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
    <!-- card -->
    <div class="card h-100 card-lift">
        <!-- card body -->
        <div class="card-body">
            <!-- heading -->
            <div class="d-flex justify-content-between align-items-center
            mb-3">
            <div>
                <h4 class="mb-0">Discussion</h4>
            </div>
            <div class="icon-shape icon-md bg-primary-soft text-primary
            rounded-2">
            <i  data-feather="target" height="20" width="20"></i>
        </div>
    </div>
    <!-- project number -->
    <div class="lh-1">
        <h1 class="mb-1 font-poppins-bold">
            {{ $discussions }}
        </h1>
        <!-- <p class="mb-0"><span class="text-success me-2">5%</span>Completed</p> -->
    </div>
</div>
</div>
</div>
</div>
</div>
    </div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header"><strong>Talk to Gener</strong>
                    <button id="toggle-chatbot" style="float: right; color: white; background: transparent; border: none;"><i class="fas fa-chevron-circle-up"></i></button>
                </div>
                    <div class="card-body">
                        <!-- Chatbot container -->
                        <div class="chatbot-container" id="chatbot-container">
                            <!-- Wrap the contents of the chatbot in a div -->
                                <div id="chatbot-contents">
                            <div class="chatbot-messages" id="chatbot-messages">
                                <!-- Chatbot messages will appear here -->
                            </div>
                            <div class="chatbot-input">
                                <form method="GET" action="{{ route('getRecommendations') }}">
                                
                                    @csrf
                                    <div style="display: flex; padding-top:30px">
                                    <textarea name="query" id="user-input" placeholder="Type your message..." autocomplete="off" required></textarea>
                                    <button type="submit" id="send-button" title="Click to send">&#10148;</button>
                                </form>
                                <div id="loading-spinner" class="spinner-border text-primary" role="status" style="display: none;">
                                    <span class="sr-only">Loading...</span>
                                </div>

                                 <!-- Add the tip element with an initial hidden state -->
                                 <div id="tip" class="tip-message" style="display: none;">
                                     <span><b>Tip:</b> Use question mark (?) in your queries for better results.</span>
                                 </div>
                            </div>
                        </div>

                    </div>
                        <div class="card-body">
                            <!-- Recommendations container -->
                            <div class="recommendations-container" id="recommendations-container">
                                <!-- Relevant resource URLs will appear here -->
                            </div>
                            <div id="hidden-chatbot-message" style="display: none;">Gener Chat is currently minimized. Click the the top right button to maximize.</div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="row">
    <!-- Most Favorite Resources Table -->
    <div class="col-md-12 col-lg-6">
        <div class="table-container-user shadow">
            <p class="h4 mb-0 font-poppins-bold mb-2">Top Resources</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Author</th>
                        <th class="text-center">Favorited</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostFavoriteResources as $resource)
                        <tr class="font-poppins-bold">
                        <td class="text-center">
            @if(!is_null($resource->college))
                <a class="hover" href="{{ route('resource.show', $resource->id) }}">
                    <strong>{{ Str::limit($resource->title, 35) }}</strong>
                </a>
            @else
                <a class="hover" href="{{ route('resource.show', $resource->id) }}" style="display: none;">
                    <strong>{{ Str::limit($resource->title, 35) }}</strong>
                </a>
            @endif
        </td>
                            <td class="text-center">{{ $resource->author }}</td>
                            <td class="text-center">
                                @if(!is_null($resource->college))
                                    {{ $resource->favorited_by_count }}
                                @else
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Most Replied Discussions Table -->
    <div class="col-md-12 col-lg-6">
        <div class="table-container-user shadow">
            <p class="h4 mb-0 font-poppins-bold mb-2">Top Discussions</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Replied</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostRepliedDiscussions as $discussion)
                        <tr class="font-poppins-bold">
                            <td class="text-center hover" onclick="window.location='{{ route('discussions.show', $discussion->slug, ['id' => $discussion->id]) }}'" style="cursor: pointer;"
                            >{{ Str::limit($discussion->title, 30) }}</td>
                            <td class="text-center">{{ $discussion->replies_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>
	
</main>
<footer class="bg-dark text-white py-3" id="footer-container">
    <p>&copy; 2023 Leyte Normal University. All Rights Reserved.</p>
    <p>LNU GENER V.1.0.0 | Maintained and Managed by PancitCantonEnjoyers</p>
</footer>
</body>
</html>

<!-- Include jQuery library -->
<script src="{{ asset('js/dashboard.js') }}"></script>


