<?php
session_start();
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
} else {
    header("Location: ../index.php"); 
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeroOne Portal</title>
    <link rel="stylesheet" href="dashboard.css"> 
</head>
<body>
    <div class="dashboard">
        <div class="dashboard-in">
            <div class="dashboard-nav">
                <?php 
                include '../../includes/dashnav.php'; 
                ?>
            </div>
            <div class="dashboard-container">
                <div class="dashboard-sidebar">
                    <?php 
                    include '../../includes/sidebar.php'; 
                    ?>
                </div>
                <div class="dashboard-content">
                    <h2>Welcome, <?php echo ucfirst($userRole); ?>!</h2>
                    <p>Your dashboard is ready to use.</p>
                    <?php if ($userRole == 'club_member'): ?>
                        <p>Here are your upcoming events...</p>
                    <?php elseif ($userRole == 'club_core'): ?>
                        <p>Manage your projects here...</p>
                    <?php elseif ($userRole == 'DSIOG'): ?>
                        <p>Your responsibilities are listed here...</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="dashboard-footer">
                <?php 
                include '../../includes/footer.php'; 
                ?> 
            </div>
        </div>
    </div>
</body>
</html>
