// -------------------------- DISCUSSIONS --------------------------------//

//Sweetalert
$(document).ready(function() {
    $('.delete-reply').on('click', function() {
        var replyId = $(this).data('reply-id');

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
                var form = document.getElementById('deleteReplyForm_' + replyId);
                form.submit();

                Swal.fire(
                    'Deleted!',
                    'Your reply has been deleted.',
                    'success'
                )
            }
        });
    });
});
