<?php
session_start();
require_once(__DIR__ . '/../../config.php');
require_once(__DIR__ . '/../../db.php'); // Include the database connection file

if (isset($_SESSION['role'])) {
    $userRole = $_SESSION['role'];
} else {
    header("Location: ../index.php");
    exit();
}
if (!isset($_SESSION['id_number'])) {
    header("Location: index.php");
    exit();
}

$pageTitle = 'Cohorts Management';
$studentData = []; // Initialize an array to hold student data
$uploadSuccess = false; // To track if the upload was successful

// Handle CSV file upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file']['tmp_name'];

    if (is_uploaded_file($file)) { // Check if the file is uploaded
        $handle = fopen($file, "r");

        if ($handle) {
            // Skip the first row (header)
            fgetcsv($handle);

            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                // Store data in the array, adjusting indexes based on the CSV format
                $studentData[] = [
                    's_no' => $data[0],          // S No
                    'id_number' => $data[1],     // ID Number
                    'name' => $data[2],          // Name
                    'mail' => $data[3],          // Mail
                    'cohort' => $data[4]         // Cohort type
                ];

                // Insert into the database (optional)
                $sql = "INSERT INTO students (name, id_number, email, cohort) VALUES (?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $data[2], $data[1], $data[3], $data[4]);
                $stmt->execute();
            }
            fclose($handle);
            $uploadSuccess = true; // Set upload success
        } else {
            echo "<p>Failed to open the file.</p>";
        }
    } else {
        echo "<p>No file uploaded.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <div class="cohorts-m-dashboard">
        <div class="cohorts-m-heading">
            <h1>Manage CoHorts of ZeroOne Code Club</h1>
        </div>

        <!-- CSV Upload -->
        <div class="cohorts-upload-csv">
            <h2>Upload Students Data (CSV)</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <input type="file" name="csv_file" accept=".csv" required><br>
                <button type="submit">Upload CSV</button>
            </form>
            <?php if ($uploadSuccess): ?>
                <p>CSV file data uploaded successfully!</p>
            <?php endif; ?>
        </div>

        <!-- Display Student List -->
        <?php if (!empty($studentData)): ?>
            <div class="student-list">
                <h2>Student List</h2>
                <table>
                    <tr>
                        <th>S No</th>
                        <th>ID Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Cohort Type</th>
                    </tr>
                    <?php foreach ($studentData as $student): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student['s_no']); ?></td>
                            <td><?php echo htmlspecialchars($student['id_number']); ?></td>
                            <td><?php echo htmlspecialchars($student['name']); ?></td>
                            <td><?php echo htmlspecialchars($student['mail']); ?></td>
                            <td><?php echo htmlspecialchars($student['cohort']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
