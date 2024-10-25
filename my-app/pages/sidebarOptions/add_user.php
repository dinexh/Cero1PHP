<?php
require_once('../../db.php');
$id_number = $name = $password = $mail = $cohort = $role = $message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form data
    $id_number = trim($_POST['id_number']);
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $mail = trim($_POST['mail']);
    $cohort = trim($_POST['cohort']);
    $role = trim($_POST['role']);
    $message = trim($_POST['message']);
    $stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, cohort, role, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $id_number, $name, $password, $mail, $cohort, $role, $message);
    if ($stmt->execute()) {
        header("location: success.php");
    } else {
        header("location: error.php");
    }
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/users.css">
</head>
<body>
    <div class="user-container">
        <div class="user-container-in">
            <div class="user-container-heading">
                <h2>User Registration</h2>
            </div>
            <div class="user-container-form">
                <form action="/pages/sidebarOptions/add_user.php" method="post"> 
                    <div class="user-form-group">
                        <label for="id_number">ID Number:</label>
                        <input type="text" id="id_number" name="id_number" required>
                    </div>
                    <div class="user-form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="user-form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <div class="user-form-group">
                        <label for="mail">Email:</label>
                        <input type="email" id="mail" name="mail" required>
                    </div>
                    <div class="user-form-group">
                        <label for="cohort">Cohort:</label>
                        <input type="text" id="cohort" name="cohort" required>
                    </div>
                    <div class="user-form-group">
                        <label for="role">Role:</label>
                        <input type="text" id="role" name="role" required>
                    </div>
                    <div class="user-form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>
                    <div class="user-form-button-group">
                        <button type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
