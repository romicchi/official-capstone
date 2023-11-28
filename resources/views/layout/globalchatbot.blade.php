<head>
    <!-- Import the Font Awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/globalchatbot.css')}}">
</head>

<body>
    <!-- Global chatbot button -->
    <button id="global-chatbot-button"><i class="fa-solid fa-user-graduate" Title="ChatBot" style="color: #3e547a; font-size: 1.5em;"></i></button>
    
    <!-- Chatbot container -->
    <div id="chatbot-container">
        <div class="chatbot-header">Talk to Gener</div>
        <div id="notification-icon" Title="Resource Recommendation" style="display: none;"><i class="fa-solid fa-bell"></i></div>
        <button id="close-chatbot-button" title="Minimize"><i class="fa-solid fa-caret-down"></i></button>
        <div id="chatbot-messages"></div>
        <div id="chatbot-form-container">
            <form id="chatbot-form">
                <input type="text" id="user-input" Title="Please fill out this field" placeholder="Type your message...">
                <button type="submit" id="send-button" title="Send">&#10148;</button>
            </form>
        </div>
    </div>

    <div id="recommendations-card" style="display: none;">
    <!-- Recommendations container -->
    <div class="recommendations-container" id="recommendations-container">
        <!-- Relevant resource URLs will appear here -->
    </div>
</div>
            
    <!-- Include jQuery library -->
    <script src="{{ asset('js/globalchatbot.js') }}"></script>
</body>
