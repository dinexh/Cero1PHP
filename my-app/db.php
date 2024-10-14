<?php
$host = 'localhost';
$db = 'zeroone_portal'; 
$user = 'root'; // your database username
$pass = 'Dinesh@123'; // your database password

// Create a connection
$conn = new mysqli($host, $user, $pass, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Optionally, you can set the character set if necessary
$conn->set_charset('utf8mb4');
?>
