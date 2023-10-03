@extends('layout.usernav')
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Dashboard</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   
        <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('css/dashboard.css')}}">
		<script src="https://js.pusher.com/7.0/pusher.min.js"></script>

            <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

      </head>
      <style>
          .border-left-primary {
              border-left: 0.25rem solid #4e73df !important;
            }
            
            .border-left-success {
                border-left: 0.25rem solid #1cc88a !important;
            }
            
            .border-left-info {
                border-left: 0.25rem solid #36b9cc !important;
            }
            
            .border-left-warning {
                border-left: 0.25rem solid #f6c23e !important;
            }

            .chatbot-container {
        max-width: 600px; /* Adjust the maximum width as needed */
        margin: 0 auto;
        padding: 20px;
        background-color: #f5f5f5;
        border-radius: 10px;
    }

    /* Style the chatbot messages and user input */
    .chatbot-messages {
        height: 300px; /* Adjust the height as needed */
        overflow-y: scroll;
        border: 1px solid #ccc;
        padding: 10px;
        background-color: #fff;
        border-radius: 5px;
    }

    .chatbot-input {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    input[type="text"] {
        flex-grow: 1;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    button#send-button {
        margin-left: 10px;
        padding: 10px 20px;
        background-color: #007bff;
        color: #fff;
        border: none;
        border-radius: 5px;
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

      </style>
    <body>
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
  <header>
		<div class="dashboard">
    <h2>Welcome to the User Dashboard, <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong></h2>
			<p>Here you can chat with our Files, manage your account, view statistics, history, and more.</p>
		</div>
	</header>
	<main>

    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Talk to Gener</div>
                <div class="card-body">
                    
                    <!-- Chatbot container -->
                    <div class="chatbot-container">
                        <!-- Include an empty container for file recommendations -->
                        
                        <div class="chatbot-messages" id="chatbot-messages">
                            <!-- Chatbot messages will appear here -->
                        </div>
                                
                        <div class="chatbot-input">
                            <form method="GET" action="{{ route('getRecommendations') }}">
                                @csrf
                                <input type="text" name="query" id="user-input" placeholder="Type your message...">
                                <button type="submit" id="send-button">Search</button>
                            </form>
                
                            <div id="loading-spinner" class="spinner-border text-primary" role="status" style="display: none;">
                                <span class="sr-only">Loading...</span>
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
     	<p>Copyright &copy; 2023 {{config('app.name')}}. All rights reserved.</p>
     </footer>
     </html>

     <script>
    document.addEventListener("DOMContentLoaded", function () {
        const recommendationsContainer = document.getElementById("recommendations-container");
        const loadingSpinner = document.getElementById("loading-spinner");

        document.querySelector("form").addEventListener("submit", function (e) {
            e.preventDefault();
            const query = document.getElementById("user-input").value;

            // Display loading spinner while fetching recommendations
            loadingSpinner.style.display = "inline-block";

            // Fetch recommendations based on the user's query
            fetch(`/get-recommendations?query=${encodeURIComponent(query)}`)
                .then((response) => response.text())
                .then((html) => {
                    // Hide loading spinner
                    loadingSpinner.style.display = "none";
                    
                    // Update the recommendations container with the fetched HTML
                    recommendationsContainer.innerHTML = html;
                })
                .catch((error) => {
                    console.error("Error fetching recommendations:", error);
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

    // Function to add a message to the chatbot messages container
    function addMessage(message, className) {
        const messageElement = document.createElement("div");
        messageElement.className = className;
        messageElement.innerText = message;
        chatbotMessages.appendChild(messageElement);
    }

    // Function to toggle the loading spinner and send button
    function toggleLoading(isLoading) {
        if (isLoading) {
            sendButton.style.display = "none";
            loadingSpinner.style.display = "block";
        } else {
            sendButton.style.display = "block";
            loadingSpinner.style.display = "none";
        }
    }

    // Function to send user input to the Flask API and display the response
    async function sendMessageToChatbot(query, modelType, muteStream, hideSource) {
        addMessage(query, "user-message");
        toggleLoading(true); // Loading spinner and hide send button

        // API request to Flask
        try {
            const response = await fetch("http://localhost:8080/api/chat", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify({
                    query,
                    model_type: modelType,
                    mute_stream: muteStream,
                    hide_source: hideSource,
                }),
            });

            if (response.ok) {
                const data = await response.json();
                const chatbotResponse = data.answer || "Chatbot didn't respond.";
                addMessage(chatbotResponse, "chatbot-message");
            } 
            
            else {
                addMessage("Error: Unable to communicate with the chatbot.", "chatbot-message");
            }
        } catch (error) {
            console.error("Error:", error);
            addMessage("Error: Unable to communicate with the chatbot.", "chatbot-message");
        } finally {
            toggleLoading(false); // Hide loading spinner and show send button
        }

        userInput.value = ""; // Clear the user input field
    }

    // Event listener for the send button
    sendButton.addEventListener("click", () => {
        const query = userInput.value;
        const modelType = "GPT4All";
        const muteStream = false;
        const hideSource = false;
        sendMessageToChatbot(query, modelType, muteStream, hideSource);
    });

    // Event listener for pressing Enter key in the input field
    userInput.addEventListener("keydown", (event) => {
        if (event.key === "Enter") {
            const query = userInput.value;
            const modelType = "GPT4All";
            const muteStream = false;
            const hideSource = false;
            sendMessageToChatbot(query, modelType, muteStream, hideSource);
        }
    });
});
</script>
