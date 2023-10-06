<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="{{ asset('assets/bootstrap/css/bootstrap.css')}}">
  <link rel="stylesheet" type="text/css" href="{{ asset ('css/chatbot.css') }}">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

@section('chatbot')
<div id="toggle-chatbot" class="chatbot-button">
  <div id="chatbot-circle">
    <span id="chatbot-question-mark">?</span>
  </div>
</div>
<div class="chatbot-wrapper" style="display:none">
  <div class="chatbot-container">
    <div id="header">
      <h1>FAQ</h1>
      <button id="close-chatbot">X</button>
    </div>
    <div id="chatbot">
      <div id="conversation">
        <div class="chatbot-message">
          <p class="chatbot-text">Hi! 👋 Ask me any question.</p>
        </div>
      </div>
      <div id="suggestions">
        <button type="button" class="suggestion">Safety?</button>
        <button type="button" class="suggestion">Resources?</button>
        <button type="button" class="suggestion">How do you do?</button>
      </div>
      <form id="input-form">
        <message-container>
          <input id="input-field" type="text" placeholder="Type your question here" autocomplete="off">
          <button id="submit-button" type="submit">
            <img class="send-icon" src="send-message.png" alt="">
          </button>
        </message-container>
      </form>
    </div>
  </div>
</div>

<script src="{{ asset('js/chatbot.js') }}"></script>
@show
