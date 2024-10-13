<?php
session_start();
require_once('config.php');

// Initialize message
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Initialize database connection
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the email exists
    $stmt = $conn->prepare("SELECT id_number FROM users WHERE mail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique token
        $token = bin2hex(random_bytes(50));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

        // Store the token and expiry in the database
        $stmt = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE mail = ?");
        $stmt->bind_param("sss", $token, $expiry, $email);

        if ($stmt->execute()) {
            // Send reset password email
            $resetLink = "http://yourdomain.com/reset_password.php?token=" . $token;
            $subject = "Password Reset Request";
            $body = "Click the following link to reset your password: " . $resetLink;
            mail($email, $subject, $body);

            $message = "Reset link has been sent to your email address.";
        } else {
            $message = "Error occurred while generating reset token.";
        }
    } else {
        $message = "Email not found.";
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="forgot-password-container">
        <h1>Forgot Password</h1>
        <form action="forgot_password.php" method="post">
            <label for="email">Enter your email address:</label>
            <input type="email" id="email" name="email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <?php if ($message): ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
    </div>
</body>
</html>
