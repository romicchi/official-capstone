// toggle favorite
$(document).ready(function () {
    $('.toggle-favorite').click(function () {
        var resourceId = $(this).data('resource-id');
        var $starIcon = $(this).find('i');

        // Add the CSRF token to the data
        var csrfToken = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: toggleFavoriteRoute,
            type: 'POST',
            data: { resourceId: resourceId, _token: csrfToken },
            success: function (data) {
                // Toggle the star icon
                $starIcon.toggleClass('fas far');

                // Update the number of favorites in the view
                var $favoritesCount = $('.favorites-count');
                if ($starIcon.hasClass('fas')) {
                    $favoritesCount.text(parseInt($favoritesCount.text()) + 1);
                } else {
                    $favoritesCount.text(parseInt($favoritesCount.text()) - 1);
                }
            }
        });
    });
});

// live search
function performLiveSearch(query) {
    $.ajax({
        url: searchUrl,
        method: 'GET',
        data: { search: query },
        success: function(response) {
            if (query.trim() === '') {
                // Show the discussion list container and hide live search results
                $('#disciplineList').show();
                $('#live-search-results').empty();
            } else {
                // Hide the discussion list container and display live search results
                $('#disciplineList').hide();
                $('#live-search-results').empty().html(response);
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

// Trigger live search on input change
$(document).ready(function() {
    $('#searchForm').on('submit', function(event) {
        event.preventDefault();
        performLiveSearch($('#searchInput').val());
    });
});
