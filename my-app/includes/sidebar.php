<?php
require_once(__DIR__ . '/../config.php');
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
} else {
    header("Location: ../index.php");
    exit();   
}
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'Guest'; 
?>
<link rel="stylesheet" href="<?php echo BASE_URL; ?>includes/sidebar.css">
<aside class="sidebar" id="sidebar">
    <div class="sidebar-in">
        <h3>Sidebar Menu</h3>
        <ul>
            <!-- common options for everyone -->
            <li><a href="#" data-page="home" class="<?php echo ($currentPage == 'home') ? 'active' : ''; ?>">Home</a></li>
            <!-- Options for club_member -->
            <?php if ($userRole == 'member'): ?>
                <li>
                    <a href="#" class="dropdown-toggle">Events</a>
                    <ul class="dropdown-menu">
                    <li><a href="#" data-page="myevents">My Events</a></li>
                        <li><a href="#" data-page="register_event">Register Event</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">Projects</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="add_project">Add Project</a></li>
                        <li><a href="#" data-page="my_projects">My Projects</a></li>
                    </ul>
                </li>
                <li><a href="#" data-page="cohorts" class="<?php echo ($currentPage == 'cohorts') ? 'active' : ''; ?>">Cohorts</a></li>
                <li><a href="#" data-page="achievements" class="<?php echo ($currentPage == 'achievements') ? 'active' : ''; ?>">Achievements</a></li>
                <li>
                    <a href="#" class="dropdown-toggle">Feedback</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="add_feedback">Add Feedback</a></li>
                        <li><a href="#" data-page="my_feedback">My Feedback</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">Grievance</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="my_grievance">My Grievance</a></li>
                        <li><a href="#" data-page="add_grievance">Add Grievence</a></li>
                    </ul>
                </li>
            <!-- Options for club_core -->
            <?php elseif ($userRole == 'club_core'): ?>
                <li><a href="#" data-page="cohorts_management" class="<?php echo ($currentPage == 'cohorts_management') ? 'active' : ''; ?>">Cohorts Management</a></li>
            <!-- Options for DSIOG -->
            <?php elseif ($userRole == 'DSIOG'): ?>
                <li>
                    <a href="#" class="dropdown-toggle">Cohorts Management</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="view_all_cohorts">View All</a></li>
                        <li><a href="#" data-page="add_cohort">Add Cohort</a></li>
                        <li><a href="#" data-page="add_users">Add users</a></li>
                    </ul>
                </li>
            <?php endif; ?>
            <!-- Options for DSIOG and club_core -->
            <?php if ($userRole == 'DSIOG' || $userRole == 'club_core'): ?>
                <li>
                    <a href="#" class="dropdown-toggle">Projects</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="ongoing_projects" class="<?php echo ($currentPage == 'ongoing_projects') ? 'active' : ''; ?>">Ongoing Projects</a></li>
                        <li><a href="#" data-page="create_project" class="<?php echo ($currentPage == 'create_project') ? 'active' : ''; ?>">Create Project</a></li>
                        <li><a href="#" data-page="my_projects" class="<?php echo ($currentPage == 'my_projects') ? 'active' : ''; ?>">My Projects</a></li>
                        <li><a href="#" data-page="all_projects" class="<?php echo ($currentPage == 'all_projects') ? 'active' : ''; ?>">All Projects</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">Events</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="plan_event" class="<?php echo ($currentPage == 'plan_event') ? 'active' : ''; ?>">Plan Event</a></li>
                        <li><a href="#" data-page="event_attendance" class="<?php echo ($currentPage == 'event_attendance') ? 'active' : ''; ?>">Attendance</a></li>
                        <li><a href="#" data-page="previous_events" class="<?php echo ($currentPage == 'previous_events') ? 'active' : ''; ?>">Previous Events</a></li>
                        <li><a href="#" data-page="my_events" class="<?php echo ($currentPage == 'my_events') ? 'active' : ''; ?>">My Events</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">Docs</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="previous_reports" class="<?php echo ($currentPage == 'previous_reports') ? 'active' : ''; ?>">Previous Reports</a></li>
                        <li><a href="#" data-page="overall" class="<?php echo ($currentPage == 'overall') ? 'active' : ''; ?>">Overall</a></li>
                        <li><a href="#" data-page="letters" class="<?php echo ($currentPage == 'letters') ? 'active' : ''; ?>">Letters</a></li>
                        <li><a href="#" data-page="circulars" class="<?php echo ($currentPage == 'circulars') ? 'active' : ''; ?>">Circulars</a></li>
                        <li><a href="#" data-page="new_report" class="<?php echo ($currentPage == 'new_report') ? 'active' : ''; ?>">New Report</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">Feedback</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="feedback_stats" class="<?php echo ($currentPage == 'feedback_stats') ? 'active' : ''; ?>">Show All Feedback Stats</a></li>
                        <li><a href="#" data-page="add_feedback">Add Feedback</a></li>
                        <li><a href="#" data-page="my_feedback">My Feedback</a></li>
                        <!-- <li><a href="#" data-page="create_feedback" class="<?php echo ($currentPage == 'create_feedback') ? 'active' : ''; ?>">Create Feedback</a></li> -->
                    </ul>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle">Grievance</a>
                    <ul class="dropdown-menu">
                        <li><a href="#" data-page="grievance_stats">View Grievance Stats</a></li>
                        <li><a href="#" data-page="add_grievance">Add Grievance</a></li>
                        <li><a href="#" data-page="my_grievance">My Grievance</a></li>
                    </ul>
                </li>
                <!-- for DSIOG -->
                <?php if ($userRole == 'DSIOG'): ?>
                    <li>
                        <a href="#" data-page="termination" class="<?php echo ($currentPage == 'termination') ? 'active' : ''; ?>">Termination</a>
                    </li>
                <?php endif; ?>
            <?php endif; ?>
            <!-- common for all -->
            <li><a href="#" data-page="profile" class="<?php echo ($currentPage == 'profile') ? 'active' : ''; ?>">Profile</a></li>
        </ul>
    </div>
</aside>

<script>
    document.querySelectorAll('.dropdown-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            e.preventDefault();
            const dropdownMenu = this.nextElementSibling;
            dropdownMenu.classList.toggle('show');
        });
    });
</script>
