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
