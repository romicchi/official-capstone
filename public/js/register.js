// JavaScript to Show Year Level Dropdown and Student Number Field
document.getElementById('role').addEventListener('change', function () {
    const yearLevelGroup = document.getElementById('yearLevelGroup');
    const studentNumberGroup = document.getElementById('studentNumberGroup');
    if (this.value === '1') {
        yearLevelGroup.style.display = 'block';
        studentNumberGroup.style.display = 'block';
    } else {
        yearLevelGroup.style.display = 'none';
        studentNumberGroup.style.display = 'none';
    }
});

// JavaScript to Show Loader When Sign Up Button is Clicked
document.getElementById('signup-button').addEventListener('click', function (event) {
    const firstname = document.getElementById('firstname').value;
    const lastname = document.getElementById('lastname').value;
    const email = document.getElementById('email').value;
    const password = document.getElementById('password').value;
    const password_confirmation = document.getElementById('password_confirmation').value;
    const role = document.getElementById('role').value;
    const year_level = document.getElementById('year_level').value;
    const student_number = document.getElementById('student_number').value;
    const college_id = document.getElementById('college_id').value;
    const id = document.getElementById('id').value;
    
    if (firstname.trim() !== '' && lastname.trim() !== '' && email.trim() !== '' && password.trim() !== '' && password_confirmation.trim() !== '' && role.trim() !== '' && college_id.trim() !== '' && id.trim() !== '') {
        event.preventDefault(); // Prevent the form submission
        // Show the loader and change the button text
        document.querySelector('.loader-container').style.display = 'block';
        this.disabled = true; // Disable the button

        // Submit the form
        this.closest('form').submit();
    }
});
