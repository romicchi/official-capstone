// LIVE SEARCH FUNCTIONALITY

//------------------------HISTORY-MANAGE-SEARCH--------------------------//

function performLiveSearch(query) {
    $.ajax({
        url: searchUrl,
        method: 'GET',
        data: { query: query },
        success: function(response) {
            if (query.trim() === '') {
                $('#history-table-container').show();
                $('#live-search-results').empty();
            } else {
                $('#history-table-container').hide();
                $('#live-search-results').html(response);
            }
        },
        error: function(xhr) {
            console.log(xhr.responseText);
        }
    });
  }
  