<!-- dashboard.php -->
<?php
session_start();

// Check if the role is set in the session
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role']; // e.g., 'club_member', 'advisor', 'dsiog'
} else {
    // Redirect to login page if not logged in
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeroOne Portal</title>
    <link rel="stylesheet" href="global.css"> <!-- Link to your global CSS -->
</head>
<body>
    <!-- Navbar -->
    <header class="navbar">
        <?php include '../includes/dashnav.php'; ?>
    </header>

    <div class="container">
        <!-- Include Sidebar -->
        <?php include '../includes/sidebar.php'; ?>

        <!-- Main Content Area -->
        <main class="main-content">
            <?php if ($userRole == 'club_member'): ?>
                <h2>Welcome, Club Member!</h2>
                <p>Your upcoming events:</p>
                <!-- Display club member-specific content -->
                <?php include 'member/member_dashboard.php'; ?>
            <?php elseif ($userRole == 'advisor'): ?>
                <h2>Welcome, Advisor!</h2>
                <p>Manage your cohorts and projects:</p>
                <!-- Display advisor-specific content -->
                <?php include 'dsiog/dsiog_dashboard.php'; ?>
            <?php elseif ($userRole == 'dsiog'): ?>
                <h2>Welcome, DSIOG!</h2>
                <p>Here are your responsibilities:</p>
                <!-- Display DSIOG-specific content -->
                <?php include 'dsiog/dsiog_dashboard.php'; ?>
            <?php else: ?>
                <h2>Welcome!</h2>
                <p>Please log in to access your dashboard.</p>
            <?php endif; ?>
        </main>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <?php include '../includes/footer.php'; ?>
    </footer>
</body>
</html>
