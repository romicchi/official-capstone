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