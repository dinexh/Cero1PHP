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
<link rel="stylesheet" href="/pages/sidebarOptions/users.css">
<body>
    <div class="container">
        <div class="container-in">
            <div class="container-heading">
                <h1>Add Users using CSV Files</h1>
            </div>
            <div class="container-form"> 
                <form action="/pages/sidebarOptions/add_users.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="file">Upload CSV File:</label>
                        <input type="file" name="file" id="file" accept=".csv" required>
                    </div>
                    <div class="form-button-group">
                        <button type="submit">Add Users</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
