function toggleCommentDropdown(event, dropdownId) {
    event.stopPropagation();
    const dropdown = document.getElementById(dropdownId);
    dropdown.classList.toggle('show');
}

$(document).on('click', function(event) {
    // Check if the clicked element is not part of the dropdown or its toggle button
    if (!$('.dots-container').is(event.target) && $('.dots-container').has(event.target).length === 0) {
        // Close any open dropdowns
        $('.menu').removeClass('show');
    }
});