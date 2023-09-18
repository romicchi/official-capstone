// -------------------------- USERMANAGE --------------------------------//
// Display image in overlay
function showImage(url) {
    // Create an overlay
    var overlay = document.createElement("div");
    overlay.className = "overlay";
    
    // Create an image element
    var image = document.createElement("img");
    image.src = url;
    image.alt = "Uploaded ID";
    image.className = "overlay-image";
    
    // Append the image to the overlay
    overlay.appendChild(image);
    
    // Append the overlay to the body
    document.body.appendChild(overlay);
    
    // Add a click event listener to close the overlay when clicked
    overlay.addEventListener("click", function() {
      document.body.removeChild(overlay);
    });
  }

  // 
  function openTab(evt, tabName) {
    var i, tabcontent, tablinks;
    tabcontent = document.getElementsByClassName("tabcontent");
    for (i = 0; i < tabcontent.length; i++) {
      tabcontent[i].style.display = "none";
    }
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
      tablinks[i].className = tablinks[i].className.replace(" active", "");
    }
    document.getElementById(tabName).style.display = "block";
    evt.currentTarget.className += " active";
  }


// -------------------------- ADMIN-EDIT --------------------------------//

        // JavaScript to Show/Hide Student Number Field
        document.getElementById('role').addEventListener('change', function () {
        const studentNumberGroup = document.getElementById('studentNumberGroup');
        if (this.value === '1') {
            studentNumberGroup.style.display = 'block';
        } else {
            studentNumberGroup.style.display = 'none';
        }
    });

    // Trigger the change event initially to show/hide based on the selected role
    document.getElementById('role').dispatchEvent(new Event('change'));

    // JavaScript to Show/Hide Year Level Field
    document.getElementById('role').addEventListener('change', function () {
    const yearLevelGroup = document.getElementById('yearLevelGroup');
    if (this.value === '1') {
      yearLevelGroup.style.display = 'block';
    } else {
      yearLevelGroup.style.display = 'none';
    }
  });

  // Trigger the change event initially to set the initial visibility state
  document.getElementById('role').dispatchEvent(new Event('change'));

  
// -------------------------- ADMIN-ADD --------------------------------//
    // Function to toggle the Year Level dropdown based on the selected role
    function toggleYearLevelDropdown() {
        var roleSelect = document.getElementById('role');
        var yearLevelContainer = document.getElementById('yearLevelContainer');

        console.log('Selected Role:', roleSelect.value);

        // If the selected role is "1" (Student), show the Year Level dropdown; otherwise, hide it
        if (roleSelect.value === '1') {
            yearLevelContainer.style.display = 'block';
        } else {
            yearLevelContainer.style.display = 'none';
        }
    }

        // JavaScript to Show/Hide Student Number Field
        document.getElementById('role').addEventListener('change', function () {
        const studentNumberGroup = document.getElementById('studentNumberGroup');
        if (this.value === '1') {
            studentNumberGroup.style.display = 'block';
        } else {
            studentNumberGroup.style.display = 'none';
        }
    });

    // Add an event listener to the Role dropdown to trigger the toggle function
    document.getElementById('role').addEventListener('change', toggleYearLevelDropdown);

    // Initialize the state of the Year Level dropdown based on the initial role value
    toggleYearLevelDropdown();