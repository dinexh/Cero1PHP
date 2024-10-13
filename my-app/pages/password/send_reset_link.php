<?php
// Include your database connection file
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idnumber = $_POST['idnumber'];  // Get the ID number from the form
    $email = $_POST['email'];        // Get the email from the form

    // Check if the ID and email exist in the database
    $query = "SELECT * FROM users WHERE idnumber = ? AND email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $idnumber, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // User exists, generate a secure token
        $token = bin2hex(random_bytes(50));  // Generates a 50-byte secure random token

        // Set token expiration (1 hour from now)
        $expires_at = date("Y-m-d H:i:s", strtotime('+1 hour'));

        // Store the token and expiration in the database
        $update_query = "UPDATE users SET reset_token = ?, token_expires = ? WHERE email = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("sss", $token, $expires_at, $email);
        $update_stmt->execute();

        // Create reset link
        $reset_link = "http://yourwebsite.com/reset_password.php?token=$token";

        // Email details
        $subject = "Password Reset Request";
        $message = "Click on the link below to reset your password:\n\n$reset_link\n\nIf you did not request this, please ignore this email.";
        $headers = "From: no-reply@yourwebsite.com";

        // Send email
        if (mail($email, $subject, $message, $headers)) {
            echo "A password reset link has been sent to your email.";
        } else {
            echo "Failed to send the email.";
        }
    } else {
        echo "No account found with that ID and email.";
    }
}
?>
