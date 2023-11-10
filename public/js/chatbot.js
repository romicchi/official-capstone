// Get chatbot elements
const chatbot = document.getElementById('chatbot');
const conversation = document.getElementById('conversation');
const inputForm = document.getElementById('input-form');
const inputField = document.getElementById('input-field');
const chatbotWrapper = document.querySelector('.chatbot-wrapper');
const toggleChatbotButton = document.getElementById('toggle-chatbot');

// Add event listener to input form
inputForm.addEventListener('submit', function (event) {
  // Prevent form submission
  event.preventDefault();

  // Get user input
  const input = inputField.value;

  // Clear input field
  inputField.value = '';
  const currentTime = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

  // Add user input to conversation
  let message = document.createElement('div');
  message.classList.add('chatbot-message', 'user-message');
  message.innerHTML = `<p class="chatbot-text" sentTime="${currentTime}">${input}</p>`;
  conversation.appendChild(message);

  // Generate chatbot response
  const response = generateResponse(input);

  // Add chatbot response to conversation
  message = document.createElement('div');
  message.classList.add('chatbot-message', 'chatbot');
  message.innerHTML = `<p class="chatbot-text" sentTime="${currentTime}">${response}</p>`;
  conversation.appendChild(message);
  message.scrollIntoView({ behavior: 'smooth' });
});

// Generate chatbot response function
function generateResponse(input) {
  // Parse the datasets JSON
  const datasets = [
    {
      "keywords": ["resources", "educational resources", "textbooks", "research", "resource"],
      "response": "Our web application provides a wide range of educational resources, including textbooks, lecture notes, video lectures, research papers, and more. You can explore resources from various colleges, courses, and subjects to support your learning."
    },
    {
      "keywords": ["open educational resources", "OER", "open"],
      "response": "We offer a collection of open educational resources (OER) that are freely available for anyone to access. These resources are created by professors and experts, ensuring credibility and relevance for your studies."
    },
    {
      "keywords": ["professors", "contributors", "teacher", "teachers"],
      "response": "Our web application features resources contributed by professors and experts from different educational institutions. Their expertise ensures the quality and credibility of the materials available on our platform."
    },
    {
      "keywords": ["safety", "credibility", "safe"],
      "response": "We prioritize the safety and credibility of our educational resources. Our team carefully reviews and curates the content to ensure it meets high standards of accuracy, reliability, and relevance for learners."
    },
    {
      "keywords": ["colleges", "institutions"],
      "response": "You can find resources from various colleges and educational institutions on our platform. We aim to provide a diverse collection that covers a wide range of subjects and courses to meet your learning needs."
    },
    {
      "keywords": ["courses", "subjects", "materials", "material"],
      "response": "Our web application offers resources for a wide variety of courses and subjects. Whether you're studying mathematics, history, information technology, or any other discipline, you can find relevant resources to support your learning journey."
    },
    {
      "keywords": ["discussion forum", "community", "forum"],
      "response": "We provide a discussion forum where you can connect with fellow learners, ask questions, share insights, and engage in educational discussions. It's a great way to collaborate and learn from a community of like-minded individuals."
    },
    {
      "keywords": ["personal notes", "note-taking", "journal", "note", "notes"],
      "response": "Our web application allows you to take personal notes while accessing educational resources. You can create, organize, and save your notes, making it easier to review and consolidate your learning."
    },
    {
      "keywords": ["history", "search history"],
      "response": "We maintain a search history feature that allows you to track and revisit your previous searches. It helps you keep a record of the resources you have explored and simplifies navigation within the web application."
    },
    {
      "keywords": ["dashboard", "user dashboard", "home"],
      "response": "Our user-friendly dashboard provides a personalized and centralized hub for your educational journey. You can access your saved resources, view progress, manage your profile, and discover new materials from the dashboard."
    },
    {
      "keywords": ["help", "assistance", "support"],
      "response": "I'm here to provide assistance with your educational needs. Feel free to ask any questions, and I'll do my best to help you."
    },
    {
      "keywords": ["features", "capabilities", "options"],
      "response": "Our platform offers a variety of features, including a discussion forum, personal note-taking, and a user dashboard. How can I assist you in using these features?"
    },
    {
      "keywords": ["community", "interact", "connect"],
      "response": "Our community forum is a great place to interact with other learners. You can ask questions, share insights, and collaborate with fellow students. How would you like to engage with the community today?"
    },
    {
      "keywords": ["gener", "GENER", "Generate Report of Educational Resource"],
      "response": "Gener is your friendly AI chatbot here to assist you with a wide range of tasks and questions. Whether it's educational support, information, or just a friendly chat, The AI is here to help! 😊"
    }
  ];

  // Iterate over the datasets and check for matching keywords
  for (const data of datasets) {
    for (const keyword of data.keywords) {
      if (input.toLowerCase().includes(keyword.toLowerCase())) {
        return data.response;
      }
    }
  }

  // If no matching keywords are found, return a default response
  const responses = [
    "Hello, how can I help you today? 😊",
    "Is there anything you like to ask? 😊",
    "How can I help you today? 😊",
    "What can I do for you today? 😊",
    "How can I assist you today? 😊",
    "What can I help you with today? 😊",
  ];

  // Return a random default response
  return responses[Math.floor(Math.random() * responses.length)];
}

toggleChatbotButton.addEventListener('click', () => {
  chatbotWrapper.style.display = chatbotWrapper.style.display === 'none' ? 'block' : 'none';
});

$(document).ready(function () {
  // Define the suggestion button click event
  $('.suggestion').on('click', function () {
    var message = $(this).text(); // Get the text of the clicked button
    $('#input-field').val(message); // Set the input field value to the button text
    $('#submit-button').click(); // Trigger the send button click event
  });
});

// -------------------CLOSE CHATBOT------------------------ //
$(document).ready(function () {
  $('#close-chatbot').click(function () {
    $('.chatbot-wrapper').hide();
  });
});