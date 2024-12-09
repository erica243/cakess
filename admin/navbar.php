    <?php
    // Assume you have a function to get the count of new/unread messages
    // You would replace this with your actual method of fetching the count
    $message_count = 0; // Replace with dynamic count from your database
    ?>

    <style>
        
   /* Define the custom background color */
   .b-lightblue {
        background-color: #4d94ff!important; /* Custom light blue background color */
        color: #000 !important; /* Text color */
    }

    #sidebar {
        width: 230px;
        background-color: #4d94ff;
        padding-top: 20px;
        position: fixed;
        height: 100%;
        overflow-y: auto;
        transition: transform 0.3s ease;
        transform: translateX(0); /* Default position for desktop */
        z-index: 1000; /* Ensure it's on top */
    }

    /* Sidebar for mobile view */
    @media (max-width: 768px) {
        #sidebar {
            transform: translateX(-100%); /* Hide sidebar by default */
            position: fixed;
            width: 230px;
        }

        #sidebar.active {
            transform: translateX(0); /* Show sidebar when active */
        }

        /* Ensure the page content shifts when sidebar is active */
        .page-content.active {
            transform: translateX(230px); /* Adjust the content */
        }
    }

    #sidebar .sidebar-list a {
        color: #000 !important; /* Text color for links */
        display: flex; /* Use flex for better alignment */
        justify-content: space-between; /* Spread out icon and text */
        align-items: center; /* Vertical alignment */
        padding: 10px 15px; /* Padding for links */
        text-decoration: none; /* Remove underline from links */
        position: relative; /* To position the badge */
    }

    #sidebar .sidebar-list a:hover {
        background-color: white !important; /* Lighter background on hover */
        color: #000 !important;
    }

    #sidebar .sidebar-list a.active {
        background-color: #99d6ff!important; /* Active item background color */
        color: #fff !important; /* Active item text color */
    }

    .notification-badge {
        background-color: red;
        color: white;
        padding: 2px 6px;
        border-radius: 50%;
        font-size: 12px;
        font-weight: bold;
        margin-left: 10px;
    }

    /* Hamburger menu button */
    .menu-btn {
        font-size: 30px;
        position: absolute;
        top: 20px;
        left: 20px;
        z-index: 1001; /* Ensure it's above the sidebar */
        background: none;
        border: none;
        cursor: pointer;
        display: none; /* Hidden by default for desktop */
    }

    @media (max-width: 768px) {
        .menu-btn {
            display: block; /* Show menu button in mobile view */
        }
    }
    .delivery-form {
        margin-top: 20px; /* Space above the form */
        padding: 15px; /* Padding for the form */
        background-color: #fff; /* White background for the form */
        border-radius: 5px; /* Rounded corners */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow */
    }

    .delivery-form input {
        width: 100%; /* Full width for inputs */
        padding: 10px; /* Padding for inputs */
        margin: 5px 0; /* Margin between inputs */
        border: 1px solid #ccc; /* Border for inputs */
        border-radius: 4px; /* Rounded corners */
    }.container {
    padding-top: 80px; /* Same as navbar height */
}
    
    </style>
<!-- Menu button (hamburger icon) -->
<button class="menu-btn" onclick="toggleSidebar()">
    &#9776; <!-- Unicode for hamburger menu -->
</button>

<nav id="sidebar" class='mx-lt-5 b-lightblue'>
    <div class="sidebar-list">
        <a href="index.php?page=home" class="nav-item nav-home">
            <span class='icon-field'><i class="fa fa-home"></i></span> Home
        </a>
        <a href="index.php?page=orders" class="nav-item nav-orders">
            <span class='icon-field'><i class="fas fa-box"></i></span> Orders
        </a>
        <a href="index.php?page=menu" class="nav-item nav-menu">
            <span class='icon-field'><i class="fa fa-list"></i></span> Menu
        </a>
        <a href="index.php?page=categories" class="nav-item nav-categories">
            <span class='icon-field'><i class="fa fa-th-list"></i></span> Category List
        </a>
        <a href="index.php?page=reports" class="nav-item nav-reports">
            <span class='icon-field'><i class="fa fa-chart-line"></i></span> Reports
        </a>
        <a href="index.php?page=message" class="nav-item nav-message">
            <span class='icon-field'><i class="fa fa-envelope"></i></span> Messages
            <?php if ($message_count > 0): ?>
                <span class="notification-badge"><?php echo $message_count; ?></span>
            <?php endif; ?>
        </a>
        <a href="index.php?page=shipping" class="nav-item nav-shipping">
            <span class='icon-field'><i class="fa fa-truck"></i></span> Fee
        </a>
        <?php if ($_SESSION['login_id'] == 1): ?>
            <a href="index.php?page=users" class="nav-item nav-users">
                <span class='icon-field'><i class="fa fa-users"></i></span> Users
            </a>
            <a href="index.php?page=site_settings" class="nav-item nav-site_settings">
                <span class='icon-field'><i class="fa fa-cogs"></i></span> Site Settings
            </a>
        <?php endif; ?>
    </div>
</nav>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Get the current page from the URL
    let currentPage = window.location.href;

    // Select all sidebar links
    let navLinks = document.querySelectorAll('#sidebar .sidebar-list a');

    // Remove any existing active classes
    navLinks.forEach(link => {
        link.classList.remove('active');
    });

    // Find and set active link
    navLinks.forEach(link => {
        // Check if the link's href is part of the current page URL
        if (currentPage.includes(link.getAttribute('href'))) {
            link.classList.add('active');
        }
    });
});

// Function to show or hide the sidebar for mobile view
function toggleSidebar() {
    var sidebar = document.getElementById("sidebar");
    var pageContent = document.querySelector(".page-content");
    
    // Toggle active class to show/hide the sidebar
    sidebar.classList.toggle("active");
    
    // Toggle content shift when sidebar is active
    pageContent.classList.toggle("active");
}

// Close the sidebar when clicking outside of it
window.onclick = function(event) {
    var sidebar = document.getElementById("sidebar");
    var menuBtn = document.querySelector(".menu-btn");

    // If the click is outside the sidebar and menu button, close the sidebar
    if (event.target !== sidebar && !sidebar.contains(event.target) && event.target !== menuBtn) {
        sidebar.classList.remove("active");
        document.body.classList.remove("sidebar-active");
        // Optional: If you have a page-content element that shifts with the sidebar, remove the active class
        var pageContent = document.querySelector(".page-content");
        pageContent.classList.remove("active");
    }
};
</script>
