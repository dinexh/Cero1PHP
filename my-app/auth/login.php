<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id_number, name, role, password FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $username);
    
    // Debugging output
    echo "Prepared statement for username: '$username'<br>";
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        echo "Query executed successfully. Number of rows found: " . $result->num_rows . "<br>";

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['id_number'] = $row['id_number'];  
                $_SESSION['username'] = $row['name'];
                $_SESSION['role'] = $row['role'];
                header('location:../pages/dashboard/dashboard.php');
                exit();
            } else {
                echo "Invalid username or password.";
            }
        } else {
            echo "No user found with this ID number.";
        }
    } else {
        echo "Error executing query: " . $stmt->error . "<br>";
    }

    $stmt->close();
}
?>