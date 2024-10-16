<?php
include_once(dirname(__DIR__, 2) . '/config.php');

header('Content-Type: application/json');

// Connect to the database
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
    exit();
}

// Log the incoming request to check if file is being sent
error_log("Request method: " . $_SERVER['REQUEST_METHOD']); // Debugging log for request method

// Handle CSV upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csvFile'])) {
    error_log("File upload detected!"); // Debugging log when file is detected

    $file = $_FILES['csvFile']['tmp_name'];

    if (($handle = fopen($file, 'r')) !== FALSE) {
        // Skip the header row
        fgetcsv($handle);

        $successCount = 0;
        $errorCount = 0;

        while (($data = fgetcsv($handle)) !== FALSE) {
            // Assuming your CSV columns are: id_number, password, name, mail, role, cohort, cohort_id
            $id_number = $conn->real_escape_string($data[0]);
            $password = password_hash($conn->real_escape_string($data[1]), PASSWORD_DEFAULT); // Hash the password
            $name = $conn->real_escape_string($data[2]);
            $mail = $conn->real_escape_string($data[3]);
            $role = $conn->real_escape_string($data[4]);
            $cohort = $conn->real_escape_string($data[5]);
            $cohort_id = intval($data[6]);

            // Prepare SQL statement
            $sql = "INSERT INTO users (id_number, password, name, mail, role, cohort, cohort_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssssssi', $id_number, $password, $name, $mail, $role, $cohort, $cohort_id);

            if ($stmt->execute()) {
                $successCount++;
            } else {
                error_log("Error inserting user $name: " . $stmt->error);
                $errorCount++;
            }
        }

        fclose($handle);
        echo json_encode(['success' => true, 'message' => "Users added successfully: $successCount. Errors for $errorCount user(s)."]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Could not open the file.']);
    }
} else {
    error_log("No file was uploaded or wrong request method!"); // Debugging log when no file is uploaded
    echo json_encode(['success' => false, 'message' => 'No file was uploaded.']);
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cohort Management - Upload Users</title>
</head>
<body>
    <h2>Cohort Management</h2>
    <h3>Upload Users CSV</h3>
    <form id="uploadCsvForm" enctype="multipart/form-data" method="POST">
    <label for="csvFile">Select CSV file:</label>
    <input type="file" id="csvFile" name="csvFile" accept=".csv" required>
    <button type="submit">Upload Users</button>
</form>

<script>
document.getElementById('uploadCsvForm').addEventListener('submit', function(event) {
    event.preventDefault(); // Prevent form from refreshing the page

    let formData = new FormData();
    let csvFile = document.getElementById('csvFile').files[0];

    if (!csvFile) {
        console.error("No file selected!"); // Debug message
        alert("Please select a CSV file.");
        return;
    }

    console.log("CSV File selected:", csvFile); // Debugging log to check if file is selected

    formData.append('csvFile', csvFile); // Append file to form data

    // Send AJAX request to upload the file
    fetch('/pages/sidebarOptions/add_users.php', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        console.log("Server response:", data); // Debugging log to view server response

        if (data.success) {
            alert("Users uploaded successfully!");
        } else {
            alert("Error: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error during file upload:', error); // Debugging log for AJAX error
        alert("An error occurred while uploading the file.");
    });
});
</script>
</body>
</html>
