// LIVE SEARCH FUNCTIONALITY

//------------------------FAVORITES-MANAGE-SEARCH--------------------------//

function searchFavorites() {
    var input, filter, favorites, favorite, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    favorites = document.getElementById("favoriteTable");
    favorite = favorites.getElementsByTagName("tr");
  
    for (i = 0; i < favorite.length; i++) {
      td = favorite[i].getElementsByTagName("td")[0];
      if (td) {
        txtValue = td.textContent || td.innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
          favorite[i].style.display = "";
        } else {
          favorite[i].style.display = "none";
        }
      }
    }
  }
  
  document.getElementById("searchInput").addEventListener("keyup", searchFavorites);  