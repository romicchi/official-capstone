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
  <!-- Nav Bar -->
  @yield('usernav')
  <!-- Content -->
  <header>
		<div class="dashboard">
    <h2>Welcome to Dashboard, <strong>{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</strong></h2>
		</div>
	</header>
	<main>
		
<!-- Content Row -->
<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-12 col-12 mb-5">
        <!-- card -->
        <div class="card h-100 card-lift">
            <!-- card body -->
            <div class="card-body">
                <!-- heading -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div>
                        <h4 class="mb-0">Projects</h4>
                    </div>
                    <div class="icon-shape icon-md bg-primary-soft text-primary rounded-2">
                        <i  data-feather="briefcase" height="20" width="20"></i>
                    </div>
                </div>
                <!-- project number -->
                <div class="lh-1">
                    <h1 class=" mb-1 fw-bold">18</h1>
                    <p class="mb-0"><span class="text-dark me-2">2</span>Completed</p>
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
                    <h4 class="mb-0">Active Task</h4>
                </div>
                <div class="icon-shape icon-md bg-primary-soft text-primary
                rounded-2">
                <i  data-feather="list" height="20" width="20"></i>
            </div>
        </div>
        <!-- project number -->
        <div class="lh-1">
            <h1 class="  mb-1 fw-bold">132</h1>
            <p class="mb-0"><span class="text-dark me-2">28</span>Completed</p>
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
                <h4 class="mb-0">Teams</h4>
            </div>
            <div class="icon-shape icon-md bg-primary-soft text-primary
            rounded-2">
            <i  data-feather="users" height="20" width="20"></i>
        </div>
    </div>
    <!-- project number -->
    <div class="lh-1">
        <h1 class="  mb-1 fw-bold">12</h1>
        <p class="mb-0"><span class="text-dark me-2">1</span>Completed</p>
    </div>
</div>
</div>
</div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
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
    const tipElement = document.getElementById("tip");

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

    // Function to show the tip
    function showTip() {
        tipElement.style.display = "block";
        setTimeout(function () {
            tipElement.style.display = "none";
        }, 5000); // Hide the tip after 5 seconds
    }

    // Event listener for clicking the text box
    userInput.addEventListener("click", function () {
        showTip();
    });

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
