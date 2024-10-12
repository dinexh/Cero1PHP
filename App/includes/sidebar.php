<!-- sidebar.php -->
<aside class="sidebar">
    <h3>Dashboard Menu</h3>
    <ul>
        <li><a href="#">Home</a></li>
        <li><a href="#">Profile</a></li>
        <?php if ($userRole == 'club_member'): ?>
            <li><a href="#">Club Events</a></li>
        <?php elseif ($userRole == 'advisor'): ?>
            <li><a href="#">Manage Cohorts</a></li>
        <?php elseif ($userRole == 'dsiog'): ?>
            <li><a href="#">DSIOG Responsibilities</a></li>
        <?php endif; ?>
        <li><a href="#">Settings</a></li>
        <li><a href="./index.php">Logout</a></li>
    </ul>
</aside>
