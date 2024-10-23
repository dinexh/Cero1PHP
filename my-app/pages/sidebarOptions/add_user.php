<?php
require_once('../../db.php');

// Initialize variables for form data and error messages
$id_number = $name = $password = $mail = $cohort = $role = $message = "";
$error_msg = "";
$success_msg = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form data
    $id_number = trim($_POST['id_number']);
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);
    $mail = trim($_POST['mail']);
    $cohort = trim($_POST['cohort']);
    $role = trim($_POST['role']);
    $message = trim($_POST['message']);

    // Prepare the SQL statement
    $stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, cohort, role, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $id_number, $name, $password, $mail, $cohort, $role, $message);

    // Execute the statement
    if ($stmt->execute()) {
        $success_msg = "User successfully inserted!";
        header("location: success.php");
    } else {
        $error_msg = "Error inserting user: " . $stmt->error;
        header("location: error.php");
    }

    // Close the statement and connection
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
    <style>
        .container {
            max-width: 400px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #218838;
        }

        .message {
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Registration</h2>
        
        <!-- Display success or error messages -->
        <?php if ($error_msg): ?>
            <div class="message error"><?php echo $error_msg; ?></div>
        <?php endif; ?>
        <?php if ($success_msg): ?>
            <div class="message success"><?php echo $success_msg; ?></div>
        <?php endif; ?>

        <form action="/pages/sidebarOptions/add_user.php" method="post"> <!-- Action points to the same file -->
            <div class="form-group">
                <label for="id_number">ID Number:</label>
                <input type="text" id="id_number" name="id_number" required>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="mail">Email:</label>
                <input type="email" id="mail" name="mail" required>
            </div>
            <div class="form-group">
                <label for="cohort">Cohort:</label>
                <input type="text" id="cohort" name="cohort" required>
            </div>
            <div class="form-group">
                <label for="role">Role:</label>
                <input type="text" id="role" name="role" required>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" required></textarea>
            </div>
            <button type="submit">Register</button>
        </form>
    </div>
</body>
</html>
