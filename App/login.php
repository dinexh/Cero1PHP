<?php
session_start();
include 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Modify the query to select id_number as well
    $stmt = $conn->prepare("SELECT id_number, name, role, password FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Check if the password is correct
        if (password_verify($password, $row['password'])) {
            // Store id_number, name, and role in session
            $_SESSION['id_number'] = $row['id_number'];  // id_number now correctly fetched
            $_SESSION['username'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == 'club_member') {
                header('Location: pages/dashboard/member/member_dashboard.php');
            } elseif ($row['role'] == 'club_core') {
                header('Location: pages/dashboard/core/core_dashboard.php');
            } elseif ($row['role'] == 'DSIOG') {
                header('Location: pages/dashboard/dsiog/dsiog_dashboard.php');
            }
            exit();
        } else {
            echo "Invalid username or password.";
        }
    } else {
        echo "Invalid username or password.";
    }

    $stmt->close();
}
?>
