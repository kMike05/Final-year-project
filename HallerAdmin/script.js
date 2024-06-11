// Select all the sidebar menu items
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

// Add click event listeners to each menu item
allSideMenu.forEach(item => {
    // Get the parent <li> element of the menu item
    const li = item.parentElement;

    // Add click event listener to the menu item
    item.addEventListener('click', function () {
        // Remove 'active' class from all menu items
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        });
        // Add 'active' class to the clicked menu item
        li.classList.add('active');
    });
});

// TOGGLE SIDEBAR
// Select the menu bar icon and the sidebar element
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

// Add click event listener to the menu bar icon
menuBar.addEventListener('click', function () {
    // Toggle the 'hide' class on the sidebar
    sidebar.classList.toggle('hide');
});

// Select the search button, its icon, and the search form
const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

// Add click event listener to the search button
searchButton.addEventListener('click', function (e) {
    // If the window width is less than 576px
    if (window.innerWidth < 576) {
        // Prevent the default form submission
        e.preventDefault();
        // Toggle the 'show' class on the search form
        searchForm.classList.toggle('show');
        // Change the search button icon based on the visibility of the form
        if (searchForm.classList.contains('show')) {
            searchButtonIcon.classList.replace('bx-search', 'bx-x');
        } else {
            searchButtonIcon.classList.replace('bx-x', 'bx-search');
        }
    }
});

// Initial setup based on window width
if (window.innerWidth < 768) {
    // Hide the sidebar if window width is less than 768px
    sidebar.classList.add('hide');
} else if (window.innerWidth > 576) {
    // Reset the search button icon and form visibility if window width is greater than 576px
    searchButtonIcon.classList.replace('bx-x', 'bx-search');
    searchForm.classList.remove('show');
}

// Add resize event listener to the window
window.addEventListener('resize', function () {
    // Reset the search button icon and form visibility if window width is greater than 576px
    if (this.innerWidth > 576) {
        searchButtonIcon.classList.replace('bx-x', 'bx-search');
        searchForm.classList.remove('show');
    }
});
