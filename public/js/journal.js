// -------------------------- JOURNALS --------------------------------//

// Dropdown
function toggleDropdown() {
    var dropdownMenu = document.getElementById("dropdownMenu");
    dropdownMenu.classList.toggle("show");
}

// Sweetalert
$(document).ready(function() {
    $('.delete-journal').on('click', function() {
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
                // Get the form element and submit it
                var form = document.getElementById('deleteForm');
                form.submit();

                Swal.fire(
                    'Deleted!',
                    'Your file has been deleted.',
                    'success'
                )
            }
        });
    });
});