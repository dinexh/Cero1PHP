<?php
session_start();
require_once('../../config.php');
require_once('../../db.php');

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['id_number']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied. Redirecting to login...";
    header("Location: /auth/login.php"); // Adjust the path as needed
    exit();
}

$response = array('success' => false, 'message' => '');

// Handle form submission to end a grievance
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Update the grievance status to closed
    $sql = "UPDATE grievances SET ongoing = 0, result = 'Closed' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = "Grievance closed successfully!";
    } else {
        $response['message'] = "Database Error: " . mysqli_error($conn);
    }

    // Redirect back to the stats page with a success/error message
    header("Location: view_gre_stats.php?message=" . urlencode($response['message']));
    exit();
} else {
    // Invalid access
    header("Location: view_gre_stats.php?message=" . urlencode("Invalid request."));
    exit();
}

$conn->close();
?>
