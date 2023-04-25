  <!-- Link to Bootstrap stylesheet -->
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset ('css/chatbot.css') }}">
  <!-- Link to jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

@section('chatbot')
  <button id="toggle-chatbot">Open Chatbot</button>

    <div class="chatbot-wrapper" style="display:none">
      <div class="chatbot-container">
          <div id="header">
              <h1>Chatbot</h1>
              <button class="d-flex justify-content-end" id="close-chatbot">X</button>
          </div>
          <div id="chatbot">
              <div id="conversation">
                  <div class="chatbot-message">
                  <p class="chatbot-text">Hi! 👋 it's great to see you!</p>
                </div>
               </div>
              <div id="suggestions">
                <button type="button" class="suggestion">Hey</button>
                <button type="button" class="suggestion">What's up?</button>
                <button type="button" class="suggestion">How do you do?</button>
              </div>
              <form id="input-form">
                <message-container>
                  <input id="input-field" type="text" placeholder="Type your message here">
                  <button id="submit-button" type="submit">
                    <img class="send-icon" src="send-message.png" alt="">
                  </button>
                </message-container>
                    
               </form>
          </div>  

      </div>
    </div>
    
    <script src="{{ asset('js/chatbot.js') }}"></script>

@endsection














