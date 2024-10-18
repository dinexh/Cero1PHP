<?php
session_start();
include '../db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare the statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id_number, name, role, password FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $username);
    
    // Debugging output (consider removing this in production)
    echo "Prepared statement for username: '$username'<br>";
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        echo "Query executed successfully. Number of rows found: " . $result->num_rows . "<br>";

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Verify the password
            if (password_verify($password, $row['password'])) {
                // Regenerate session ID to prevent session fixation
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['id_number'] = $row['id_number'];  
                $_SESSION['username'] = $row['name'];
                $_SESSION['role'] = $row['role'];

                // Redirect to the dashboard
                header('Location: ../pages/dashboard/dashboard.php');
                exit();
            } else {
                echo "Invalid username or password."; // This message can be generic
            }
        } else {
            echo "No user found with this ID number."; // This message can be generic
        }
    } else {
        echo "Error executing query: " . $stmt->error; // Consider logging this instead
    }

    // Close the statement
    $stmt->close();
}
?>
