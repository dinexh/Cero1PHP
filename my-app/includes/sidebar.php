<?php
require_once(__DIR__ . '/../config.php');
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
} else {
    header("Location: ../index.php"); 
    exit();
}
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>includes/sidebar.css">
<aside class="sidebar">
    <div class="sidebar-in">
        <h3>Dashboard Menu</h3>
        <ul>
            <!-- Home and Profile -->
            <li><a href="#" data-page="home" class="<?php echo ($currentPage == 'home') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="#" data-page="profile" class="<?php echo ($currentPage == 'profile') ? 'active' : ''; ?>">Profile</a></li>

            <!-- Options for club_member -->
            <?php if ($userRole == 'club_member'): ?>
                <li><a href="#" data-page="cohorts" class="<?php echo ($currentPage == 'cohorts') ? 'active' : ''; ?>">Cohorts</a></li>
                <li><a href="#" data-page="projects" class="<?php echo ($currentPage == 'projects') ? 'active' : ''; ?>">Projects</a></li>
                <li><a href="#" data-page="events" class="<?php echo ($currentPage == 'events') ? 'active' : ''; ?>">Events</a></li>
                <li><a href="#" data-page="achievements" class="<?php echo ($currentPage == 'achievements') ? 'active' : ''; ?>">Achievements</a></li>
                <li><a href="#" data-page="feedback" class="<?php echo ($currentPage == 'feedback') ? 'active' : ''; ?>">Feedback</a></li>
                <li><a href="#" data-page="ticket_raise" class="<?php echo ($currentPage == 'ticket_raise') ? 'active' : ''; ?>">Ticket Raise</a></li>

            <!-- Options for club_core and DSIOG -->
            <?php elseif ($userRole == 'club_core' || $userRole == 'DSIOG'): ?>
                <li><a href="#" data-page="cohorts_management" class="<?php echo ($currentPage == 'cohorts_management') ? 'active' : ''; ?>">Cohorts Management</a></li>
                <li><a href="#" data-page="projects_management" class="<?php echo ($currentPage == 'projects_management') ? 'active' : ''; ?>">Projects Management</a></li>
                <li><a href="#" data-page="events_management" class="<?php echo ($currentPage == 'events_management') ? 'active' : ''; ?>">Events Management</a></li>
                <li><a href="#" data-page="reports" class="<?php echo ($currentPage == 'reports') ? 'active' : ''; ?>">Reports</a></li>
                <li><a href="#" data-page="feedback_statistics" class="<?php echo ($currentPage == 'feedback_statistics') ? 'active' : ''; ?>">Feedback Statistics</a></li>
                <li><a href="#" data-page="ticket_management" class="<?php echo ($currentPage == 'ticket_management') ? 'active' : ''; ?>">Ticket Management</a></li>
                <li><a href="#" data-page="termination" class="<?php echo ($currentPage == 'termination') ? 'active' : ''; ?>">Termination</a></li>
            <?php endif; ?>

            <!-- Settings and Logout -->
            <li><a href="#" data-page="settings" class="<?php echo ($currentPage == 'settings') ? 'active' : ''; ?>">Settings</a></li>
            <li><a href="<?php echo BASE_URL; ?>logout.php">Logout</a></li>
        </ul>
    </div>
</aside>

