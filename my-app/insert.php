<?php
include 'db.php'; // Ensure your database connection is established

// User data
$id_number = '2300030350';
$name = 'Dinesh Korukonda';
$password = '123';
$mail = '2300030350@kluniversity.in';
$cohort = 'TNTC';
$role = 'DSIOG';
$message = 'zeroone';

// Prepare the SQL statement
$stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, cohort, role, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $id_number, $name, $password, $mail, $cohort, $role, $message);

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
