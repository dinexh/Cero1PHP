<?php
// Include database connection file
include('../../../db.php');

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    // Update user role in the database
    $sql = "UPDATE users SET role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $new_role, $user_id);

    if ($stmt->execute()) {
        // Redirect back to cohort_management.php with success message
        header("Location: view_all_cohorts.php?status=success");
    } else {
        // Redirect back with an error message
        header("Location: view_all_cohorts.php?status=error");
    }

    $stmt->close();
    $conn->close();
}
?>
