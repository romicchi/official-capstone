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
	<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
            <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
    <header>
      <div class="dashboard">
          <h2>Welcome, <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong></h2>
		</div>
    </header>
		
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
                                    <div style="display: flex;">
                                    <input type="text" name="query" id="user-input" placeholder="Type your message..." autocomplete="off" required>
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
            <p class="h4 mb-0 text-gray-800 text-center mb-2">Top Resources</p>
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
                        <tr>
                            <td class="text-center hover" onclick="window.location='{{ route('resource.show', $resource->id) }}'" style="cursor: pointer;"
                            >{{ Str::limit($resource->title, 30) }}</td>
                            <td class="text-center">{{ $resource->author }}</td>
                            <td class="text-center">{{ $resource->favorited_by_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Most Replied Discussions Table -->
    <div class="col-md-12 col-lg-6">
        <div class="table-container-user shadow">
            <p class="h4 mb-0 text-gray-800 text-center mb-2">Top Discussions</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Replied</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostRepliedDiscussions as $discussion)
                        <tr>
                            <td class="text-center hover" onclick="window.location='{{ route('discussions.show', $discussion->slug, ['id' => $discussion->id]) }}'" style="cursor: pointer;"
                            >{{ Str::limit($discussion->title, 50) }}</td>
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>


