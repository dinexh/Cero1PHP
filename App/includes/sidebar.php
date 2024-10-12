<aside class="sidebar">
    <ul>
        <?php if ($userRole == 'club_member'): ?>
            <li><a href="cohorts.php">Cohorts</a></li>
            <li><a href="projects.php">Projects</a></li>
            <li><a href="events.php">Events</a></li>
            <li><a href="achievements.php">Achievements</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="ticket_raise.php">Ticket Raise</a></li>
            <li><a href="profile.php">Profile</a></li>
        <?php elseif ($userRole == 'advisor' || $userRole == 'dsiog'): ?>
            <li><a href="cohorts_management.php">Cohorts Management</a></li>
            <li><a href="projects_management.php">Projects Management</a></li>
            <li><a href="events_management.php">Events Management</a></li>
            <li><a href="reports.php">Reports</a></li>
            <li><a href="feedback_statistics.php">Feedback Statistics</a></li>
            <li><a href="ticket_management.php">Ticket Management</a></li>
            <li><a href="termination.php">Termination</a></li>
        <?php endif; ?>
    </ul>
</aside>
