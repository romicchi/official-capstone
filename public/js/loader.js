
// Show the loader when the page starts loading
document.addEventListener("DOMContentLoaded", function () {
    document.querySelector('.loader-container').style.display = 'block';
});

// Hide the loader when the page finishes loading
window.addEventListener("load", function () {
    document.querySelector('.loader-container').style.display = 'none';
});

// JavaScript to Show Loader When Login Button is Clicked
document.getElementById('login-button').addEventListener('click', function () {
    // Show the loader
    document.querySelector('.loader-container').style.display = 'block';
});

// Toggle Password
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
  const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
  password.setAttribute('type', type);
  this.classList.toggle('fa-eye-slash');
});

