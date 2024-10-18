<?php
include 'db.php'; // Ensure your database connection is established

// User data
$id_number = '230003035';
$name = 'Dinesh Korukonda';
$password = password_hash('123', PASSWORD_DEFAULT); // Hash the password
$mail = '2300030350@kluniversity.in';
$cohort = 'TNTC';
$role = 'DSIOG';
$message_code = 'zeroone';

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, cohort, role, message_code) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $id_number, $name, $password, $mail, $cohort, $role, $message_code);

// Execute the statement
if ($stmt->execute()) {
    echo "User successfully inserted!";
} else {
    echo "Error inserting user: " . $stmt->error;
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>
