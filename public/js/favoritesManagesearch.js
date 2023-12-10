// LIVE SEARCH FUNCTIONALITY

//------------------------FAVORITES-MANAGE-SEARCH--------------------------//

function performLiveSearch(query) {
  $.ajax({
      url: searchUrl,
      method: 'GET',
      data: { query: query },
      success: function(response) {
          if (query.trim() === '') {
              $('#favorite-table-container').show(); // Show the favorite table if query is empty
              $('#live-search-results').empty(); // Clear the live search results
          } else {
              $('#favorite-table-container').hide(); // Hide the favorite table if there's a query
              $('#live-search-results').html(response); // Display the live search results
          }
      },
      error: function(xhr) {
          console.log(xhr.responseText);
      }
  });
}