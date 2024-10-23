<?php
require_once('../../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"]["tmp_name"];
    
    if (file_exists($file)) {
        $handle = fopen($file, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Assuming the CSV columns are: id_number, name, password, mail, cohort, role, message
            $id_number = trim($data[0]);
            $name = trim($data[1]);
            $password = trim($data[2]);
            $mail = trim($data[3]);
            $cohort = trim($data[4]);
            $role = trim($data[5]);
            $message = trim($data[6]);

            // Log the role to see what is being processed
            error_log("Processing role: '$role' for user: '$name'");

            // Check if role is valid
            $valid_roles = ['member', 'core', 'DSIOG'];
            if (!in_array($role, $valid_roles)) {
                echo "<script>showToast('Invalid role: \"$role\" for user: \"$name\"');</script>";
                continue; // Skip this iteration
            }

            // Prepare the SQL statement
            $stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, cohort, role, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $id_number, $name, $password, $mail, $cohort, $role, $message);
            
            // Check for successful execution
            if (!$stmt->execute()) {
                // Show a toast error notification
                echo "<script>showToast('Error inserting user: " . $stmt->error . "');</script>";
            }
        }
        fclose($handle);
        // echo "<script>showToast('Users successfully added!');</script>";
        header("location : sucess.php");
    } else {
        // echo "<script>showToast('File does not exist.');</script>";
        header("location : error.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Users</title>
</head>
<body>
    <div class="container">
        <h1>Add Users</h1>
        <form action="/pages/sidebarOptions/add_users.php" method="POST" enctype="multipart/form-data">
            <label for="file">Upload CSV File:</label>
            <input type="file" name="file" id="file" accept=".csv" required>
            <button type="submit">Add Users</button>
        </form>
    </div>
</body>
</html>
