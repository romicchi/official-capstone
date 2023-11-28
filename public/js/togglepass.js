// Toggle Password
const togglePassword = document.querySelector('#togglePassword');
const password = document.querySelector('#password');

togglePassword.addEventListener('click', function () {
  const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
  password.setAttribute('type', type);
  this.classList.toggle('fa-eye-slash');
});

// Toggle Confirmation Password
const toggleConfirmationPassword = document.querySelector('#toggleConfirmationPassword');
const confirmationPassword = document.querySelector('#password_confirmation');

toggleConfirmationPassword.addEventListener('click', function () {
  const type = confirmationPassword.getAttribute('type') === 'password' ? 'text' : 'password';
  confirmationPassword.setAttribute('type', type);
  this.classList.toggle('fa-eye-slash');
});
