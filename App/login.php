<?php
session_start();
include 'db.php'; 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $stmt = $conn->prepare("SELECT id_number, name, role, password FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['id_number'] = $row['id_number'];  
            $_SESSION['username'] = $row['name'];
            $_SESSION['role'] = $row['role'];
            // for roles
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
