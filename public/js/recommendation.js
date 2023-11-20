$(document).ready(function () {
    $('.toggle-favorite').click(function () {
        var resourceId = $(this).data('resource-id');
        var $starIcon = $(this).find('i');
        var csrfToken = $('meta[name="csrf-token"]').attr('content');
        var toggleFavoriteUrl = $('#toggleFavorite').data('toggle-favorite'); // Get URL from data attribute

        $.ajax({
            url: toggleFavoriteUrl,
            type: 'POST',
            data: { resourceId: resourceId, _token: csrfToken },
            success: function (data) {
                $starIcon.toggleClass('fas far');
                var $favoritesCount = $('.favorites-count');
                if ($favoritesCount.length) {
                    $favoritesCount.text(data.favoritesCount);
                }
            }
        });
    });
});
