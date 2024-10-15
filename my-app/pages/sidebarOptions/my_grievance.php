<?php
session_start();
require_once('../../db.php'); 
if (!isset($_SESSION['id_number'])) {
    header("Location: /auth/login.php"); 
    exit();
}
$id_number = mysqli_real_escape_string($conn, $_SESSION['id_number']);
$sql = "SELECT user_id, date_reported, domain, information FROM grievances WHERE user_id = '$id_number' ORDER BY date_reported DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grievances</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/greivance.css"> 
</head>
<body>
    <div class="gre-container">
        <div class="gre-container-in">
            <div class="gre-container-in-heading">
                <h1>My Grievances</h1>
            </div>
            <div class="gre-container-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Date Reported</th>
                            <th>Domain</th>
                            <th>Information</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['date_reported']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['domain']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['information']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>No grievances found</td></tr>";
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
