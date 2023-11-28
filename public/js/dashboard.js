$(document).ready(function () {
    const recommendationsContainer = $("#recommendations-container");
    $('#chatbot-messages').append('<div class="chatbot-message">Hi I\'m Gener, Ask me anything!</div>');
    const loadingSpinner = $("#loading-spinner");

    // Hide the recommendations container initially
    recommendationsContainer.hide();

    const chatbotMessages = $("#chatbot-messages");
    const userInput = $("#user-input");
    const sendButton = $("#send-button");
    const loadingSpinnerChatbot = $("#loading-spinner");
    const tipElement = $("#tip");

    function addMessage(message, role) {
        const messageElement = $("<div></div>").addClass(role + "-message").text(message);
        chatbotMessages.append(messageElement);
    }

    function toggleLoading(isLoading) {
        sendButton.css("display", isLoading ? "none" : "block");
        loadingSpinnerChatbot.css("display", isLoading ? "block" : "none");
    }

    async function sendMessageToChatbot(query) {
        addMessage(query, "user");
        userInput.val("");
        userInput.prop("disabled", true);
        userInput.attr("placeholder", "Gener is thinking for a response...");

        // Simulate a loading animation with '...'
        let dots = '';
        const loadingInterval = setInterval(() => {
            dots = dots.length < 3 ? dots + '.' : '';
            userInput.attr("placeholder", "Gener is thinking for a response" + dots);
        }, 500);

        toggleLoading(true);

        try {
            // Send the user's query to the Flask API
            const flaskUrl = 'https://generflask.online/ask'; // Update the URL
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
            clearInterval(loadingInterval);
            userInput.attr("placeholder", "Type your message...");
            userInput.prop("disabled", false);
            toggleLoading(false);
        }

        userInput.val("");
    }

    $("form").on("submit", function (e) {
        e.preventDefault();
        const query = userInput.val();
        if (query.trim() !== "") {
            sendMessageToChatbot(query);
        }

        // Display loading spinner while fetching recommendations
        loadingSpinner.show();

        // Fetch recommendations based on the user's query using jQuery
        $.ajax({
            url: `/get-recommendations?query=${encodeURIComponent(query)}`,
            method: "GET",
            success: function (html) {
                // Update the recommendations container with the fetched HTML
                recommendationsContainer.html(html);
                
                // Show the recommendations container
                recommendationsContainer.show();
            },
            error: function (error) {
                console.error("Error fetching recommendations:", error);
            },
        });
    });

    tipElement.css("display", "block");
    setTimeout(function () {
        tipElement.css("display", "none");
    }, 8000);

    $('#toggle-chatbot').click(function() {
        $(this).find('i').toggleClass('fa-chevron-circle-up fa-chevron-circle-down');
    
        $('#chatbot-contents').slideToggle(function() {
            // Check the visibility of the chatbot
            if ($('#chatbot-contents').is(':visible')) {
                // If the chatbot is visible, hide the message
                $('#hidden-chatbot-message').hide();
            } else {
                // If the chatbot is not visible, show the message
                $('#hidden-chatbot-message').show();
            }
        });
    });
});
 
