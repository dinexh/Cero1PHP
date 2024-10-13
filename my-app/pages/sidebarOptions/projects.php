<?php
session_start();
require_once(__DIR__ . '/../../config.php'); // Adjust the path
if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
} else {
    header("Location: ../index.php"); 
    exit();
}
if (!isset($_SESSION['id_number'])) {
    header("Location: index.php"); 
    exit();
}
$pageTitle = 'Projects';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
</head>
<body>
    <div class="content">
        <h1>Projects</h1>
        <p>Manage your projects here...</p>
        <!-- Add your project management content here -->
    </div>
</body>
</html>
