<?php
require_once('../../db.php');

// Fetch all cohorts from the database
$sql = "SELECT cohort_name, batch, motto, estimated_number FROM cohorts";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cohorts</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/view_cohorts.css">
</head>
<body>
    <div class="view-container">
        <div class="view-container-in">
            <div class="view-container-in-heading">
                <h2>All Cohorts</h2>
            </div>
            <div class="view-container-table">
                <table>
                    <thead>
                        <tr>
                            <th>Cohort Name</th>
                            <th>Batch</th>
                            <th>Motto</th>
                            <th>Estimated Number</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row["cohort_name"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["batch"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["motto"]) . "</td>";
                                echo "<td>" . htmlspecialchars($row["estimated_number"]) . "</td>";
                                echo "<td>
                                        <button onclick=\"viewMembers('" . htmlspecialchars($row["cohort_name"]) . "')\">View Members</button>
                                        <button onclick=\"editCohort('" . htmlspecialchars($row["cohort_name"]) . "')\">Edit</button>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='5'>No cohorts found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function viewMembers(cohortName) {
            // Implement view members functionality
            alert("View members of " + cohortName);
        }

        function editCohort(cohortName) {
            // Implement edit cohort functionality
            alert("Edit cohort " + cohortName);
        }
    </script>
</body>
</html>

<?php
$conn->close();
?>
