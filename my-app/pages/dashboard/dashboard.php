<?php
session_start();
require_once '../../db.php';
require_once '../../config.php';
if (!isset($_SESSION['id_number'])) {
    header("Location: ../index.php");
    exit();
}
$userId = $_SESSION['id_number'];
$query = $conn->prepare('SELECT role FROM users WHERE id = ?');
$query->bind_param('i', $userId);
if ($query->execute()) {
    $query->bind_result($userRole);
    $query->fetch();
} else {
    echo "Error executing query: " . $query->error;
    exit();
}
$query->close();

$pageTitle = 'Dashboard'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="dashboard.css"> 
</head>
<body>
    <div class="dashboard">
        <div class="dashboard-in">
            <div class="dashboard-nav">
                <?php include '../../includes/dashnav.php'; ?>
            </div>
            <div class="dashboard-container">
                <div class="dashboard-sidebar">
                    <?php include '../../includes/sidebar.php'; ?>
                </div>
                <div class="dashboard-content">
                    <?php include '../sidebarOptions/home.php'; ?>
                </div>
            </div>
            <div class="dashboard-footer">
                <?php include '../../includes/footer.php'; ?>
            </div>
        </div>
    </div>
    <script src="dashboard.js"></script>
</body>

</html>
<script>
      const baseURL = "<?php echo BASE_URL; ?>";
</script>