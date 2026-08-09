<?php
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$currentPage = basename($_SERVER['PHP_SELF']);
?>
<style>
    :root {
        --primary-color: #2e7d32;
        --secondary-color: #4caf50;
        --light-color: #e8f5e9;
        --dark-color: #1b5e20;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
    }

    .sidebar {
        background-color: var(--primary-color);
        color: white;
        height: 100vh;
        position: fixed;
        padding-top: 20px;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.1);
        overflow-y: auto;
    }
    
    /* Hide scrollbar - Chrome, Safari */
    .sidebar::-webkit-scrollbar {
        width: 0px;
        background: transparent;
    }
    
    /* Hide scrollbar - Firefox */
    .sidebar {
        scrollbar-width: none;
    }
    
    /* Hide scrollbar - IE & Edge */
    .sidebar {
        -ms-overflow-style: none;
    }


    .sidebar .nav-link {
        color: rgba(255, 255, 255, 0.8);
        padding: 12px 20px;
        margin: 5px 0;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .sidebar .nav-link:hover,
    .sidebar .nav-link.active {
        background-color: rgba(255, 255, 255, 0.1);
        color: white;
    }

    .sidebar .nav-link i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    .main-content {
        margin-left: 250px;
        padding: 20px;
    }

    .header {
        background-color: white;
        padding: 15px 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card {
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        border: none;
    }

    .card-header {
        background-color: white;
        border-bottom: 1px solid #eee;
        font-weight: 600;
        padding: 15px 20px;
        border-radius: 8px 8px 0 0 !important;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .btn-primary:hover {
        background-color: var(--dark-color);
        border-color: var(--dark-color);
    }

    .table th {
        background-color: var(--light-color);
        color: var(--dark-color);
    }

    .logo {
        text-align: center;
        padding: 20px 0;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 20px;
    }

    .logo h3 {
        font-weight: 700;
        margin: 0;
    }

    .logo span {
        color: var(--light-color);
        font-weight: 300;
    }

    .stats-card {
        text-align: center;
        padding: 20px;
        border-radius: 8px;
        color: white;
        margin-bottom: 20px;
    }

    .stats-card.blue {
        background-color: #2196f3;
    }

    .stats-card.green {
        background-color: var(--secondary-color);
    }

    .stats-card.orange {
        background-color: #ff9800;
    }

    .stats-card.purple {
        background-color: #9c27b0;
    }

    .stats-card .number {
        font-size: 2rem;
        font-weight: 700;
        margin: 10px 0;
    }

    .action-buttons .btn {
        margin-right: 5px;
    }

    .form-container {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .dashboard-section {
        display: none;
    }

    .dashboard-section.active {
        display: block;
    }
</style>
<!-- Sidebar -->
<div class="col-md-3 col-lg-2 sidebar">
    <div class="logo">
        <h3>GreenEdge</h3>
    </div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'index.php') ? 'active' : '' ?>" href="index.php" data-target="dashboard">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_news.php') ? 'active' : '' ?>" 
               href="manage_news.php">
                <i class="fas fa-newspaper"></i> Latest News
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_blogs.php') ? 'active' : '' ?>" href="manage_blogs.php" data-target="blogs">
                <i class="fas fa-blog"></i> Blogs
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_resources.php') ? 'active' : '' ?>" 
               href="manage_resources.php">
                <i class="fas fa-book-open"></i> Resources
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_publications.php') ? 'active' : '' ?>" 
               href="manage_publications.php">
                <i class="fas fa-file-lines"></i> Publications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_career.php') ? 'active' : '' ?>" href="manage_career.php" data-target="career">
                <i class="fas fa-briefcase"></i> Career
            </a>
        </li>
        <li class="nav-item">
    <a class="nav-link <?= ($currentPage == 'manage_internship.php') ? 'active' : '' ?>" href="manage_internship.php" data-target="internship">
        <i class="fas fa-graduation-cap"></i> Internship
    </a>
</li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_job_applications.php') ? 'active' : '' ?>" 
               href="manage_job_applications.php">
                <i class="fas fa-user-tie"></i> Job Applications
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_products.php') ? 'active' : '' ?>" href="manage_products.php" data-target="products">
                <i class="fas fa-solar-panel"></i> Products
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_services.php') ? 'active' : '' ?>" href="manage_services.php" data-target="services">
                <i class="fas fa-tools"></i> Services
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_faq.php') ? 'active' : '' ?>" 
               href="manage_faq.php">
                <i class="fas fa-question-circle"></i> FAQ
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage_events.php') ? 'active' : '' ?>" 
               href="manage_events.php">
                <i class="fas fa-calendar-alt"></i> Events
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'event_registrations.php') ? 'active' : '' ?>" 
               href="event_registrations.php">
                <i class="fas fa-user-check"></i> Event Registrations
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'solar_requests.php') ? 'active' : '' ?>" href="solar_requests.php" data-target="solar-requests">
                <i class="fas fa-file-alt"></i> Solar Calculator 
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link <?= ($currentPage == 'manage-contacts.php') ? 'active' : '' ?>" href="manage-contacts.php" data-target="solar-requests">
                <i class="fas fa-file-alt"></i> Contact Inquiries
            </a>
        </li>
        <li class="nav-item mt-4">
            <a class="nav-link" href="logout.php">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </li>
    </ul>
</div>