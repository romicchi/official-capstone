// LIVE SEARCH FUNCTIONALITY

//------------------------JOURNAL-MANAGE-SEARCH--------------------------//

function searchJournals() {
    var input, filter, journals, journal, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    journals = document.getElementById("journal-list");
    journal = journals.getElementsByTagName("a");
  
    for (i = 0; i < journal.length; i++) {
      txtValue = journal[i].textContent || journal[i].innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        journal[i].style.display = "";
      } else {
        journal[i].style.display = "none";
      }
    }
  }
  
  document.getElementById("searchInput").addEventListener("keyup", searchJournals);  