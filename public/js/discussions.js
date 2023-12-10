// Discussions - create.blade.php
document.addEventListener('DOMContentLoaded', function() {
    const channelSelect = document.getElementById('channel');
    const courseSelect = document.getElementById('course');

    channelSelect.addEventListener('change', function() {
        const selectedChannelId = this.value;
        fetchCourses(selectedChannelId);
    });

    function fetchCourses(channelId) {
        const url = `/get-courses/${channelId}`;

        fetch(url)
            .then(response => response.json())
            .then(data => {
                courseSelect.innerHTML = '';

                data.forEach(course => {
                    const option = document.createElement('option');
                    option.value = course.id;
                    option.textContent = course.courseName;
                    courseSelect.appendChild(option);
                });
            })
            .catch(error => console.error(error));
    }
});

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

// Discussion-header
function toggleDropdown(dropdownId) {
    var dropdownMenu = document.getElementById(dropdownId);
    dropdownMenu.classList.toggle("show");
}

$(document).on('click', function(event) {
    // Check if the clicked element is not part of the dropdown or its toggle button
    if (!$('.dots-container').is(event.target) && $('.dots-container').has(event.target).length === 0) {
        // Close any open dropdowns
        $('.menu').removeClass('show');
    }
});
    
$(document).ready(function() {
    $('.delete-discussion').on('click', function() {
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
                    'Your discussion has been deleted.',
                    'success'
                )
            }
        });
    });
});


// livesearch
function performLiveSearch(query) {
    $.ajax({
        url: searchUrl,
        method: 'GET',
        data: { search: query },
        success: function(response) {
            if (query.trim() === '') {
                // If the query is empty, show the full discussion list container
                $('#discussionList').show();
                $('#live-search-results').empty();
            } else {
                // Hide the discussion list container and display live search results
                $('#discussionList').hide();
                $('#live-search-results').html(response);
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
}

// Trigger live search on input change
$(document).ready(function() {
    $('#searchInput').on('input', function() {
        performLiveSearch($(this).val());
    });
});