$(document).ready(function () {
    const recommendationsContainer = $("#recommendations-container");
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
        chatbotMessages.scrollTop(chatbotMessages[0].scrollHeight); // Scroll to the bottom
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


            // Show note after sending a message
            $("#note").css("display", "block");
            setTimeout(function () {
                $("#note").css("display", "none");
            }, 8000);
            // Add click event to close the note
             $("#close-note").on("click", function () {
                 $("#note").css("display", "none");
             });

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

    $("#chatbot-form").on("submit", function (e) {
        e.preventDefault();
        const query = userInput.val();
        if (query.trim() !== "") {
            sendMessageToChatbot(query);
        }
    
            // Display loading spinner while fetching recommendations
            loadingSpinner.show();

            // Add a click event listener to the notification icon
            $('#notification-icon').click(function() {
                // Stop the swing animation and change the color of the icon to dark grey
                $(this).css('animation', 'none');
                $(this).css('color', 'darkgrey');
            });

            // Fetch recommendations based on the user's query using jQuery
            $.ajax({
                url: `/get-recommendations?query=${encodeURIComponent(query)}`,
                method: "GET",
                success: function (html) {
                    // Insert the recommendations into the card
                    $('#recommendations-card').html(html);
                    
                    // Only start the swing animation if there are available related resources
                    if (!html.includes("No Available Related Resource")) {
                    // Show the recommendations card
                    $('#notification-icon').show();
                    // Apply the swing animation to the notification icon
                    // Start the swing animation and change the color of the icon back to its original color
                     $('#notification-icon').css('animation', 'swing 1s');
                     $('#notification-icon').css('animation-iteration-count', 'infinite');
                     $('#notification-icon').css('color', 'red'); // Replace '' with the original color of the icon
                    }
                },
                error: function (error) {
                    console.error("Error fetching recommendations:", error);
                },
            });
        });

    var isChatbotOpened = false; // Add this line at the start of your script

$('#global-chatbot-button').click(function() {
    $('#chatbot-container').slideDown();
    $('#global-chatbot-button').fadeOut();

    if (!isChatbotOpened) {
        addMessage("Hi I'm Gener, Ask me anything!", "chatbot");
        tipElement.css("display", "block");
    setTimeout(function () {
        tipElement.css("display", "none");
    }, 8000);
        isChatbotOpened = true;
    }
});

    $('#close-chatbot-button').click(function() {
        $('#chatbot-container').slideUp(); // Hide the chatbot container with a sliding effect
        $('#recommendations-card').hide(); // Hide Recommendation container if open
        $('#global-chatbot-button').fadeIn(); // Make the button reappear
    });

    $('#notification-icon').click(function() {
        // Toggle the visibility of the recommendations card when the notification icon is clicked
        $('#recommendations-card').toggle();
    });
    
});