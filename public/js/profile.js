// -------------------------- SETTINGS --------------------------------//

// Profile Update SweetAlert
$('#profileSubmitBtn').on('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to update your profile information!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form if confirmed
            $(this).closest('form').submit();
        }
    });
});

// Password Change SweetAlert
$('#passwordChangeSubmitBtn').on('click', function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to change your password!",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, change it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Submit the form if confirmed
            $(this).closest('form').submit();
        }
    });
});
