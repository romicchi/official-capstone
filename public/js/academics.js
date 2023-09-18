// -------------------------- ACADEMICS --------------------------------//

   // Function to show SweetAlert2 confirmation dialog
   function showDeleteConfirmation(callback) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            callback();
        }
    });
}

// Attach event listeners to delete buttons
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.delete-confirm');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const form = this.closest('form');
            showDeleteConfirmation(() => {
                form.submit();
            });
        });
    });
});

// Get the value of activeTab from the data attribute
const activeTabElement = document.getElementById('activeTab');
const activeTab = activeTabElement.getAttribute('data-active-tab');

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

// Highlight the active tab when the page loads
window.onload = function () {
    if (activeTab) {
        const tabButton = document.querySelector(`.tablinks[data-tab="${activeTab}"]`);
        if (tabButton) {
            tabButton.click();
        }
    }
};