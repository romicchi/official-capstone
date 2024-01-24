<head>
    <!-- Import the Font Awesome library -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/globalchatbot.css')}}">
</head>

<body>
    <!-- Global chatbot button -->
<button id="global-chatbot-button">
    <img src="{{ asset('assets/img/gener2.png') }}" alt="ChatBot" style="width: 60px; height: 60px; border-radius: 50%;">
</button>
    
    <!-- Chatbot container -->
    <div id="chatbot-container" >
    <div class="chatbot-header"><i class="fa-regular fa-comments" style="#ffffff"></i>   Talk to  <span style="border: 2px solid yellow; padding: 2px">GENER</span></div>
        <div id="notification-icon" Title="Resource Recommendation"><i class="fa-solid fa-bell"></i></div>
        <button id="close-chatbot-button" title="Minimize"><i class="fa-solid fa-caret-down"></i></button>
        <div id="chatbot-messages"></div>
        <!-- Add the tip element with an initial hidden state -->
<div id="tip" class="tip-message" style="display: none;">
                                     <span><b>Tip:</b> Use question mark (?) in your queries for better results.</span>
                                 </div>
                                 <div id="note" class="note-message" style="display: none;">
    <button id="close-note" style="position: absolute; top: 0; right: 0; background: transparent; font-weight: bold; color: black;">x</button>
    <span><b>Note:</b> Do not cite responses from the chatbot directly. Please use the recommendation system below to find resources that can be cited."</span>
</div>

        <div id="chatbot-form-container">
            <form id="chatbot-form">
                <textarea id="user-input" Title="Please fill out this field" placeholder="Type your message..."></textarea>
                <button type="submit" id="send-button" title="Send">&#10148;</button>
            </form>
        </div>
    </div>

    <div id="recommendations-card" style="display: none; z-index: 9999">
    <!-- Recommendations container -->
    <div class="recommendations-container" id="recommendations-container">
        <!-- Relevant resource URLs will appear here -->
    </div>
    <p id="no-recommendations" style="display: none;">Ask question first. Relevant Resources will display here.</p>
</div>
            
    <!-- Include jQuery library -->
    <script src="{{ asset('js/globalchatbot.js') }}"></script>
    <script>
    window.onload = function() {
        var container = document.getElementById('recommendations-container');
        var message = document.getElementById('no-recommendations');

        if (container.children.length === 0) {
            message.style.display = 'block';
        }
    };
</script>
</body>
