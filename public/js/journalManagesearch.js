// LIVE SEARCH FUNCTIONALITY

//------------------------JOURNAL-MANAGE-SEARCH--------------------------//

function performLiveSearch(query) {
  $.ajax({
      url: '/journals', // Update the URL as needed
      method: 'GET',
      data: { search: query },
      success: function(response) {
          if (query.trim() === '') {
              $('#journal-list-container').show(); // Show the journal list container if query is empty
              $('#live-search-results').empty(); // Clear the live search results
          } else {
              $('#journal-list-container').hide(); // Hide the journal list container if there's a query
              $('#live-search-results').html(response); // Display the live search results
          }
      },
      error: function(xhr) {
          console.log(xhr.responseText);
      }
  });
}
