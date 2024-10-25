<?php
// Include the configuration file
include_once __DIR__ . '/config.php';

// Create a connection using the constants from config.php
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, set the character set if necessary
$conn->set_charset('utf8mb4');
?>
