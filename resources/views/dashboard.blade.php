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
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
            <!-- Custom fonts for this template-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>

      </head>
      <style>      
    .chatbot-container {
        width: 100%; /* Adjust the maximum width as needed */
        margin: 0 auto;
        padding: 20px;
        background-color: #f5f5f5;
        border-radius: 10px;
    }

    /* Style the chatbot messages and user input */
    .chatbot-messages {
        height: 400px; /* Adjust the height as needed */
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #fff;
        border-radius: 5px;
    }

    .chatbot-input input[type=text] {
        width: 90%;
        height: 40px;
        margin-top: 10px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        resize: vertical;
        }

    button#send-button {
        width: 10%;
        height: 40px;
        margin-top: 10px; 
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #007bff;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
    }

    /* Define styles for chatbot messages and user messages */
    .chatbot-message {
        background-color: #007bff;
        color: #fff;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .user-message {
        background-color: #f5f5f5;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .tip-message {
        display: none;
        position: absolute;
        background-color: #D4D4D4;
        color: #151515;
        padding: 10px;
        border-radius: 5px;
        margin-top: -40px; 
        margin-left: 10px; 
        z-index: 1;
    }

      </style>
    <body>
<body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
    <header>
      <div class="dashboard">
          <h2>Welcome, <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong></h2>
		</div>
    </header>
	<main>
		
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><strong>Talk to Gener</strong></div>
                    <div class="card-body">
                        <!-- Chatbot container -->
                        <div class="chatbot-container">
                            <!-- Include an empty container for file recommendations -->
                            <div class="chatbot-messages" id="chatbot-messages">
                                <!-- Chatbot messages will appear here -->
                            </div>
                            <div class="chatbot-input">
                                <form method="GET" action="{{ route('getRecommendations') }}">
                                <form method="POST" action="{{ route('askChatbot') }}">
                                    @csrf
                                    <div style="display: flex;">
                                    <input type="text" name="query" id="user-input" placeholder="Type your message...">
                                    <button type="submit" id="send-button">&#10148;</button>
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

                        <!-- Recommendations container -->
                        <div class="recommendations-container" id="recommendations-container">
                            <!-- Relevant resource URLs will appear here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
    </body>
         <footer>    

     </footer>
<div class="row">
    <!-- Most Favorite Resources Table -->
    <div class="col-md-12 col-lg-6">
        <div class="table-container shadow">
            <p class="h4 mb-0 text-gray-800 text-center mb-2">Top Resources</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Author</th>
                        <th class="text-center">Favorited</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostFavoriteResources as $resource)
                        <tr>
                            <td class="text-center">{{ Str::limit($resource->title, 30) }}</td>
                            <td class="text-center">{{ $resource->author }}</td>
                            <td class="text-center">{{ $resource->favorited_by_count }}</td>
                            <td>
                                <a class="text-decoration" href="{{ route('resource.show', $resource->id) }}">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Most Replied Discussions Table -->
    <div class="col-md-12 col-lg-6">
        <div class="table-container shadow">
            <p class="h4 mb-0 text-gray-800 text-center mb-2">Top Discussions</p>
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">Title</th>
                        <th class="text-center">Replied</th>
                        <th class="text-center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($mostRepliedDiscussions as $discussion)
                        <tr>
                            <td class="text-center">{{ Str::limit($discussion->title, 50) }}</td>
                            <td class="text-center">{{ $discussion->replies_count }}</td>
                            <td><a class="text-decoration" href="{{ route('discussions.show', $discussion->slug, ['id' => $discussion->id]) }}">View</a></td>
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

<script>
    $(document).ready(function () {
        const recommendationsContainer = $("#recommendations-container");
        const loadingSpinner = $("#loading-spinner");

        $("form").on("submit", function (e) {
            e.preventDefault();
            const query = $("#user-input").val();

            // Display loading spinner while fetching recommendations
            loadingSpinner.css("display", "inline-block");

            // Fetch recommendations based on the user's query using jQuery
            $.ajax({
                url: `/get-recommendations?query=${encodeURIComponent(query)}`,
                method: "GET",
                success: function (html) {
                    // Hide loading spinner
                    loadingSpinner.css("display", "none");

                    // Update the recommendations container with the fetched HTML
                    recommendationsContainer.html(html);
                },
                error: function (error) {
                    console.error("Error fetching recommendations:", error);
                },
            });
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const chatbotMessages = document.getElementById("chatbot-messages");
    const userInput = document.getElementById("user-input");
    const sendButton = document.getElementById("send-button");
    const loadingSpinner = document.getElementById("loading-spinner");
    const tipElement = document.getElementById("tip");

    function addMessage(message, role) {
        const messageElement = document.createElement("div");
        messageElement.classList.add(role + "-message");
        messageElement.textContent = message;
        chatbotMessages.appendChild(messageElement);
    }

    function toggleLoading(isLoading) {
        sendButton.style.display = isLoading ? "none" : "block";
        loadingSpinner.style.display = isLoading ? "inline-block" : "none";
    }

    function showTip() {
        tipElement.style.display = "block";
        setTimeout(function () {
            tipElement.style.display = "none";
        }, 5000);
    }

    async function sendMessageToChatbot(query) {
        addMessage(query, "user");
        toggleLoading(true);

        try {
            // Send the user's query to the Flask API
            const flaskUrl = 'http://192.168.1.10:8080/ask'; // Update the URL
            const response = await fetch(flaskUrl, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    query: query,
                }),
            });

            if (response.ok) {
                const data = await response.json();
                const chatbotResponse = data.answers[0];
                addMessage(chatbotResponse, "chatbot");
            } else {
                addMessage("Error: Unable to communicate with the chatbot", "chatbot");
            }
        } catch (error) {
            console.error("Error:", error);
            addMessage("Error: Unable to communicate with the chatbot", "chatbot");
        } finally {
            toggleLoading(false);
        }

        userInput.value = "";
    }

    sendButton.addEventListener("click", () => {
        const query = userInput.value;
        if (query.trim() !== "") {
            sendMessageToChatbot(query);
        }
    });

    userInput.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            const query = userInput.value;
            if (query.trim() !== "") {
                sendMessageToChatbot(query);
            }
        }
    });

    showTip();
});
</script>

