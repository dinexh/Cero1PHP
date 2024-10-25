<?php
require_once('../../db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"]["tmp_name"];
    
    if (file_exists($file)) {
        $handle = fopen($file, "r");
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $id_number = trim($data[0]);
            $name = trim($data[1]);
            $password = trim($data[2]);
            $mail = trim($data[3]);
            $cohort = trim($data[4]);
            $role = trim($data[5]);
            $message = trim($data[6]);
            $valid_roles = ['member', 'core', 'DSIOG'];
            $stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, cohort, role, message) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssss", $id_number, $name, $password, $mail, $cohort, $role, $message);
        }
        fclose($handle);
        header("location : sucess.php");
    } else {
        header("location : error.php");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Users using CSV</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/users.css">
</head>
<body>
    <div class="csv-container">
        <div class="csv-container-in">
            <div class="csv-container-heading">
                <h1>Add Users using CSV Files</h1>
            </div>
            <div class="csv-content">
                <div class="csv-form-section">
                    <h2>Upload CSV</h2>
                    <form action="/pages/sidebarOptions/add_users.php" method="POST" enctype="multipart/form-data">
                        <div class="csv-form-group">
                            <label for="file">Select CSV File:</label>
                            <input type="file" name="file" id="file" accept=".csv" required>
                        </div>
                        <div class="csv-form-button-group">
                            <button type="submit">Add Users</button>
                        </div>
                    </form>
                </div>
                <div class="csv-info-section">
                    <h2>Instructions</h2>
                    <ul>
                        <li>Prepare a CSV file with user details.</li>
                        <li>Ensure the CSV has the following columns:
                            <ol>
                                <li>ID Number</li>
                                <li>Name</li>
                                <li>Password</li>
                                <li>Email</li>
                                <li>Cohort</li>
                                <li>Role</li>
                                <li>Message</li>
                            </ol>
                        </li>
                        <li>Upload the CSV file using the form.</li>
                        <li>Click "Add Users" to import the data.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
