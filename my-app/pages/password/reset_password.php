<?php
// Include your database connection
include 'db.php';

if (isset($_GET['token'])) {
    $token = $_GET['token'];  // Get the token from the URL

    // Verify the token in the database and check if it has expired
    $query = "SELECT * FROM users WHERE reset_token = ? AND token_expires > NOW()";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Token is valid, display form to enter new password
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $new_password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // Hash the new password

            // Update the password in the database and remove the token
            $update_query = "UPDATE users SET password = ?, reset_token = NULL, token_expires = NULL WHERE reset_token = ?";
            $update_stmt = $conn->prepare($update_query);
            $update_stmt->bind_param("ss", $new_password, $token);
            $update_stmt->execute();

            echo "Password has been reset successfully.";
        }
    } else {
        // Invalid or expired token
        echo "Invalid or expired token.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="forgotpassword.css">
</head>
<body>
    <div class="reset-password-container">
        <h2>Reset Password</h2>
        <form action="" method="post">
            <div class="input-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="input-group">
                <button type="submit">Reset Password</button>
            </div>
        </form>
    </div>
</body>
</html>
