<?php
session_start();
require_once('config.php');

// Initialize message
$message = "";

// Check if user is logged in
if (!isset($_SESSION['id_number'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];
    $userId = $_SESSION['id_number']; // Assuming you store user ID in session

    // Initialize database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Verify the old password
    $stmt = $conn->prepare("SELECT password FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        // Check if the old password matches
        if (password_verify($oldPassword, $row['password'])) {
            if ($newPassword === $confirmPassword) {
                // Hash the new password
                $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

                // Update the password in the database
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id_number = ?");
                $stmt->bind_param("ss", $hashedPassword, $userId);

                if ($stmt->execute()) {
                    // Password updated successfully, destroy session and log out
                    session_destroy(); // Log out the user
                    header("Location: login.php?message=Password changed successfully. Please log in again.");
                    exit();
                } else {
                    $message = "Error updating password.";
                }
            } else {
                $message = "New passwords do not match.";
            }
        } else {
            $message = "Old password is incorrect.";
        }
    } else {
        $message = "User not found.";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="change-password-container">
        <h1>Change Password</h1>
        <form action="change_password.php" method="post">
            <label for="old_password">Old Password:</label>
            <input type="password" id="old_password" name="old_password" required>

            <label for="new_password">New Password:</label>
            <input type="password" id="new_password" name="new_password" required>

            <label for="confirm_password">Confirm New Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Change Password</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
