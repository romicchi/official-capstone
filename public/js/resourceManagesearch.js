// LIVE SEARCH FUNCTIONALITY

//------------------------ADMIN-MANAGE-RESOURCES--------------------------//

function performLiveSearch(query) {
  $.ajax({
      url: searchUrl,
      method: 'GET',
      data: { search: query },
      success: function(response) {
          if (query.trim() === '') {
              // If the query is empty, show the full resource list container
              $('#resourceTable').show();
              $('#live-search-results').empty();
          } else {
              // Hide the resource list container and display live search results
              $('#resourceTable').hide();
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