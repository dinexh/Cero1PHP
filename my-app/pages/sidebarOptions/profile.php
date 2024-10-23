<?php
session_start();
require_once('../../config.php');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$message = "";
$successMessage = "";

if (!isset($_SESSION['id_number'])) {
    header("Location: ../index.php");
    exit();
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_number = $_SESSION['id_number'];

// Handle form submission for updating password and message
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $new_message = $_POST['new_message'] ?? ''; // Updated to reflect 'message'

    // Log that form data was received
    error_log("Form data received");

    $sql = "SELECT password, message FROM users WHERE id_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_number);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Log that the user was found
        error_log("User found");

        // Verify old password
        if ($old_password === $user['password']) {  // Compare plain text
            error_log("Old password is correct");

            // Check if new password and confirm password match
            if ($new_password === $confirm_password && !empty($new_password)) {
                $update_sql = "UPDATE users SET password = ? WHERE id_number = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $new_password, $id_number); // Store as plain text

                if ($update_stmt->execute()) {
                    error_log("Password updated successfully");
                    $successMessage = "Password updated successfully.";
                    header("Location: /../../index.php");
                    exit();
                } else {
                    error_log("Error updating password: " . $update_stmt->error);
                    $message = "Error updating password. Please try again.";
                }
                $update_stmt->close();
            } elseif (empty($new_password)) {
                $message = "New password cannot be empty.";
            } else {
                $message = "New password and confirmation do not match.";
            }

            // Update message if provided
            if (!empty($new_message)) {
                $update_code_sql = "UPDATE users SET message = ? WHERE id_number = ?"; // Updated to reflect 'message'
                $update_code_stmt = $conn->prepare($update_code_sql);
                $update_code_stmt->bind_param("ss", $new_message, $id_number);

                if ($update_code_stmt->execute()) {
                    header("Location: success.php");
                    exit(); // Ensure the script stops after redirection
                } else {
                    error_log("Error updating message: " . $update_code_stmt->error);
                    $message = "Error updating message. Please try again.";
                }
                $update_code_stmt->close();
            }
        } else {
            error_log("Old password is incorrect");
            $message = "Old password is incorrect.";
        }
    } else {
        error_log("Error fetching user password: " . $stmt->error);
        $message = "Error fetching user data. Please try again.";
    }

    $stmt->close();
}

// Fetch user details for display
$sql = "SELECT id_number, name, mail, role, cohort, message FROM users WHERE id_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_number);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
    error_log("Error fetching user details: " . $stmt->error);
    $message = "Error fetching user details.";
}

$stmt->close();
$conn->close();
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
        <div class="profile-container-in">
            <div class="profile-view">
                <div class="profile-view-heading">
                    <h1>User Profile Preview</h1>
                </div>
                <div class="profile-view-table">
                    <table>
                        <tr>
                            <th>Field</th>
                            <th>Details</th>
                        </tr>
                        <tr>
                            <td>Username</td>
                            <td><?= htmlspecialchars($user['id_number']) ?></td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td><?= htmlspecialchars($user['name']) ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td><?= htmlspecialchars($user['mail']) ?></td>
                        </tr>
                        <tr>
                            <td>CoHort</td>
                            <td><?= htmlspecialchars($user['cohort']) ?></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                        </tr>
                        <tr>
                            <td>Message</td>
                            <td><?= htmlspecialchars($user['message']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="profile-edit">
                <div class="profile-edit-heading">
                    <h1>Edit Password and Message</h1>
                </div>
                <div class="profile-edit-options">
                    <form action="/pages/sidebarOptions/profile.php" method="POST">
                        <label for="old_password">Old Password:</label>
                        <input type="text" id="old_password" name="old_password" required> <!-- Change type to text -->

                        <label for="new_password">New Password:</label>
                        <input type="text" id="new_password" name="new_password" required> <!-- Change type to text -->

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="text" id="confirm_password" name="confirm_password" required> <!-- Change type to text -->

                        <label for="new_message">New Message:</label>
                        <input type="text" id="new_message" name="new_message" value="<?= htmlspecialchars($user['message']) ?>">

                        <button type="submit">Save Changes</button>
                    </form>
                    <?php if (!empty($message)): ?>
                        <div class="error"><?= htmlspecialchars($message) ?></div>
                    <?php endif; ?>
                    <?php if (!empty($successMessage)): ?>
                        <div class="success"><?= htmlspecialchars($successMessage) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
