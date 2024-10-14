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

// Handle form submission for updating password
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $sql = "SELECT password FROM users WHERE id_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id_number);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Verify old password
        if (password_verify($old_password, $user['password'])) {
            // Check if new password and confirm password match
            if ($new_password === $confirm_password) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET password = ? WHERE id_number = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param("ss", $hashed_new_password, $id_number);

                if ($update_stmt->execute()) {
                    $successMessage = "Password updated successfully.";
                } else {
                    $message = "Error updating password.";
                }
                $update_stmt->close();
            } else {
                $message = "New password and confirmation do not match.";
            }
        } else {
            $message = "Old password is incorrect.";
        }
    } else {
        $message = "Error fetching user details.";
    }

    $stmt->close();
}

// Fetch user details for display
$sql = "SELECT id_number, name, mail, role , cohort FROM users WHERE id_number = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id_number);

if ($stmt->execute()) {
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
} else {
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
                            <td><?= htmlspecialchars($user['cohort'])?></td>
                        </tr>
                        <tr>
                            <td>Role</td>
                            <td><?= htmlspecialchars($user['role']) ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="profile-edit">
                <div class="profile-edit-heading">
                    <h1>Edit Password</h1>
                </div>
                <div class="profile-edit-options">
                    <form action="" method="POST">
                        <label for="old_password">Old Password:</label>
                        <input type="password" id="old_password" name="old_password" required>

                        <label for="new_password">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required>

                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required>

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
