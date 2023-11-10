
// Show the loader when the page starts loading
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.loader-container').style.display = 'block';
});

// Hide the loader when the page finishes loading
window.addEventListener("load", function () {
    document.querySelector('.loader-container').style.display = 'none';
});

// JavaScript to Show Loader When Login Button is Clicked
document.getElementById('login-button').addEventListener('click', function (event) {
    const emailOrStudentNumber = document.getElementById('email_or_student_number').value;
    const password = document.getElementById('password').value;
    
    if (emailOrStudentNumber.trim() !== '' && password.trim() !== '') {
        event.preventDefault(); // Prevent the form submission
        // Show the loader and change the button text
        document.querySelector('.loader-container').style.display = 'block';
        this.disabled = true; // Disable the button
        this.innerHTML = this.getAttribute('data-loading-text'); // Change button text
        document.querySelector('form').submit(); // Submit the form
    }
});

// Toggle Password
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
  const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
  password.setAttribute('type', type);
  this.classList.toggle('fa-eye-slash');
});

