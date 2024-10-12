<?php
session_start(); // Start the session if it's not already started

// Unset all session variables
$_SESSION = [];

// Destroy the session
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session
session_destroy();

// Redirect to the login page or home page
header("Location: /index.php"); // Adjust the path to your login page
exit; // Ensure no further code is executed after the redirect
?>
