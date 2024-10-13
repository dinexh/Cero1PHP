<?php
session_start();
require_once('../../config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);
$message = "";
if (!isset($_SESSION['id_number'])) {
    header("Location: ../login.php");
    exit();
}
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$id_number = $_SESSION['id_number'];
$sql = "SELECT name, mail, password FROM users WHERE id_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_number);
if ($stmt->execute()) {
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    $message = "Error fetching user details.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/options.css">  
</head>
<body>
    <div class="profile-container">
        <div class="profile-table">
            <h1>User Profile</h1>
            <h2>Name: <?= htmlspecialchars($user['name']) ?></h2>
            <h3>Email: <?= htmlspecialchars($user['mail']) ?></h3>
        </div>
    </div>
</body>
</html>
