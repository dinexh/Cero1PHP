<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgotpassword.css">
</head>
<body>
    <div class="forgot-password-container">
        <div class="forgot-password-form">
            <h2>Forgot Password</h2>
            <p>Please enter your ID number and email address to receive a password reset link.</p>
            <form action="send_reset_link.php" method="post">
                <div class="input-group">
                    <label for="idnumber">ID Number</label>
                    <input type="text" id="idnumber" name="idnumber" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <button type="submit">Send Reset Link</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
