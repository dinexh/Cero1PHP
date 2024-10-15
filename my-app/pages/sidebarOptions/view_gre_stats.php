<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once('../../config.php');
require_once('../../db.php');

// Debugging: Check if session variables are set
// echo "ID Number: " . (isset($_SESSION['id_number']) ? $_SESSION['id_number'] : 'Not Set') . "<br>";
// echo "Role: " . (isset($_SESSION['role']) ? $_SESSION['role'] : 'Not Set') . "<br>";

// Ensure the user is logged in and is an admin
if (!isset($_SESSION['id_number']) || $_SESSION['role'] !== 'admin') {
    echo "Access denied. Redirecting to login...";
    header("Location: /auth/login.php"); // Adjust the path as needed
    exit();
}

// Query to fetch all grievances
$sql = "SELECT id, user_id, domain, information, date_reported, ongoing, result FROM grievances ORDER BY date_reported DESC";
$result = $conn->query($sql);

// Check for query errors
if (!$result) {
    die("Query Failed: " . mysqli_error($conn));
}

// Debugging: Check if any grievances are fetched
// echo "Number of grievances: " . $result->num_rows . "<br>";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Grievance Statistics</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/greivence.css">
</head>
<body>
    <div class="gre-container">
        <div class="gre-container-in">
            <div class="gre-container-heading">
                <h1>View Grievance Statistics</h1>
            </div>
            <div class="gre-container-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User ID</th>
                            <th>Date Reported</th>
                            <th>Domain</th>
                            <th>Information</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date_reported']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['domain']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['information']) . "</td>";
                                echo "<td>" . ($row['ongoing'] ? "Ongoing" : "Closed") . "</td>";
                                echo "<td>";
                                if ($row['ongoing']) {
                                    echo "<form method='POST' action='end_grievance.php' style='display:inline;'>";
                                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>";
                                    echo "<input type='submit' value='End Grievance'>";
                                    echo "</form>";
                                } else {
                                    echo "N/A";
                                }
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No grievances found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>
