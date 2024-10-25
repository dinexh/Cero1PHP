<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and assign form data
    $cohort_name = trim($_POST['cohort_name']);
    $batch = trim($_POST['batch']);
    $motto = trim($_POST['motto']);
    $estimated_number = trim($_POST['estimated_number']);

    // Handle file upload
    if (isset($_FILES['csv_file']) && $_FILES['csv_file']['error'] == 0) {
        $file_tmp = $_FILES['csv_file']['tmp_name'];
        $csv_data = array_map('str_getcsv', file($file_tmp));

        // Start a transaction
        $conn->begin_transaction();

        try {
            // Insert or update cohort data into database
            $stmt = $conn->prepare("INSERT INTO cohorts (cohort_name, batch, motto, estimated_number) 
                                     VALUES (?, ?, ?, ?) 
                                     ON DUPLICATE KEY UPDATE 
                                     motto = VALUES(motto), 
                                     estimated_number = VALUES(estimated_number)");
            $stmt->bind_param("sssi", $cohort_name, $batch, $motto, $estimated_number);
            $stmt->execute();

            // Prepare statement for inserting CSV data
            $stmt = $conn->prepare("INSERT INTO cohort_members (name, email, cohort_name, batch) 
                                     VALUES (?, ?, ?, ?) 
                                     ON DUPLICATE KEY UPDATE 
                                     name = VALUES(name)"); // Optional, in case you want to update names

            // Skip the header row if it exists
            $start_row = (isset($csv_data[0][0]) && $csv_data[0][0] == 'Name') ? 1 : 0;

            for ($i = $start_row; $i < count($csv_data); $i++) {
                $name = $csv_data[$i][0];
                $email = $csv_data[$i][1];
                $stmt->bind_param("ssss", $name, $email, $cohort_name, $batch);
                $stmt->execute();
            }

            // Commit the transaction
            $conn->commit();
            $message = "Cohort and member data added successfully.";
        } catch (Exception $e) {
            // An error occurred, rollback the transaction
            $conn->rollback();
            $message = "Error: " . $e->getMessage();
        }

        $stmt->close();
    } else {
        $message = "Error: CSV file is required.";
    }
    
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cohort</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/add_cohort.css">
</head>
<body>
    <div class="cohort-container">
        <div class="cohort-container-in">
            <div class="cohort-container-heading">
                <h2>Add New Cohort</h2>
            </div>
            <?php if (!empty($message)): ?>
                <div class="message"><?php echo $message; ?></div>
            <?php endif; ?>
            <div class="cohort-container-form">
                <form action="/pages/sidebarOptions/add_cohort.php" method="post" enctype="multipart/form-data">
                    <div class="cohort-form-group">
                        <label for="cohort_name">Cohort Name:</label>
                        <input type="text" id="cohort_name" name="cohort_name" required>
                    </div>
                    <div class="cohort-form-group">
                        <label for="batch">Batch:</label>
                        <input type="text" id="batch" name="batch" required>
                    </div>
                    <div class="cohort-form-group">
                        <label for="motto">Motto:</label>
                        <input type="text" id="motto" name="motto" required>
                    </div>
                    <div class="cohort-form-group">
                        <label for="estimated_number">Estimated Number of People:</label>
                        <input type="number" id="estimated_number" name="estimated_number" required>
                    </div>
                    <div class="cohort-form-group file-upload">
                        <label for="csv_file">Upload CSV Data (required):</label>
                        <input type="file" id="csv_file" name="csv_file" accept=".csv" required>
                    </div>
                    <div class="cohort-form-button-group">
                        <button type="submit">Add Cohort</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
