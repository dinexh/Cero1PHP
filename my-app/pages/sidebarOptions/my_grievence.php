<?php
require_once('../../config.php');
require_once('../../db.php');

// Query to fetch data from the grievances table
$sql = "SELECT id_number, grievance_date, `option`, description, added, ongoing, result FROM grievances";

// Execute the query
$result = $conn->query($sql);
?>

<html>
<head>
    <title>My Grievances</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/greivence.css">
</head>
<body>
    <div class="gre-container">
        <div class="gre-container-in">
            <div class="gre-container-heading">
                <h1>My Grievances</h1>
            </div>
            <div class="gre-container-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Grievance Date</th>
                            <th>Option</th>
                            <th>Description</th>
                            <th>Added</th>
                            <th>Ongoing</th>
                            <th>Result</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            // Fetch and display each row of data
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['id_number']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['grievance_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['option']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['added']) . "</td>";
                                echo "<td>" . ($row['ongoing'] ? 'Yes' : 'No') . "</td>";
                                echo "<td>" . htmlspecialchars($row['result']) . "</td>";
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
