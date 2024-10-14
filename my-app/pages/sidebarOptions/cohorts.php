<?php
session_start();
require_once(__DIR__ . '/../../../config.php');
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

$pageTitle = 'Cohorts';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="content">
        <h1>Cohorts</h1>
        <p>List of upcoming cohorts...</p>
        <!-- Add your cohort content here -->
    </div>
</body>
</html>
