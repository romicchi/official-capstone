     // Function to show SweetAlert2 confirmation dialog
     function showDeleteConfirmation(callback) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

// Attach event listeners to delete buttons in usermanage
document.addEventListener('DOMContentLoaded', () => {
    const deleteButtons = document.querySelectorAll('.delete-confirm');
    deleteButtons.forEach((button) => {
        button.addEventListener('click', (event) => {
            event.preventDefault();
            showDeleteConfirmation(() => {
                window.location.href = button.href;
            });
        });
    });

    var deleteHistoryButtons = document.querySelectorAll('.delete-history');

    deleteHistoryButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var form = this.parentElement; // Get the parent form element

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will be removed from your history.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });

    var deleteHistoryButtons = document.querySelectorAll('.delete-favorite');

    deleteHistoryButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var form = this.parentElement; // Get the parent form element

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will be removed from your favorites.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, remove it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });

    var deleteHistoryButtons = document.querySelectorAll('.clear-favorite');

    deleteHistoryButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var form = this.parentElement; // Get the parent form element

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will be clear your favorites.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });

    var deleteHistoryButtons = document.querySelectorAll('.clear-history');

    deleteHistoryButtons.forEach(function(button) {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            var form = this.parentElement; // Get the parent form element

            Swal.fire({
                title: 'Are you sure?',
                text: 'This will be clear your history.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, clear it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit(); // Submit the form if confirmed
                }
            });
        });
    });
});

// Function to show SweetAlert2 confirmation dialog
function showResourceDeleteConfirmation(callback) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',

        // Show cancel button
        showCancelButton: true,

        // Confirm button text
        confirmButtonText: 'Yes, delete it!',

        // Cancel button text
        cancelButtonText: 'No, cancel!',

        // Custom CSS classes
        customClass: {
            confirmButton: 'btn btn-danger mx-2',
            cancelButton: 'btn btn-secondary',
        },
        buttonsStyling: false,
    }).then((result) => {
        // If confirmed, execute callback
        if (result.isConfirmed) {
            callback();
        }
    });
}

// sweetalert when resource delete button is clicked
document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.getElementsByClassName('delete-resource-confirm');

    for (var i = 0; i < deleteButtons.length; i++) {
        deleteButtons[i].addEventListener('click', function(event) {
            // Prevent the form from submitting
            event.preventDefault();

            // Get the form
            var form = this.form;

            // Show the confirmation dialog
            showResourceDeleteConfirmation(function() {
                // Submit the form
                form.submit();
            });
        });
    }
});