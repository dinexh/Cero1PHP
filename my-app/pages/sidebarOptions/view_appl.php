<?php
// Include database connection
require_once('../../db.php');
require_once '../../config.php';

// Fetch all applications from the database
$query = "SELECT * FROM core_team_applications ORDER BY id DESC";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if (!$result) {
    die("Database query failed.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Applications</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/view_appl.css">
</head>
<body>
    <div class="app-container">
        <div class="app-container-in">
            <div class="app-container-heading">
                <h1>Core Team Applications</h1>
            </div>
            <div class="app-container-table">
            <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>ID Number</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Domain</th>
                    <th>Role Expectations</th>
                    <th>Club Expectations</th>
                    <th>Full Potential</th>
                    <th>Previous Experience</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['id_number']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><?php echo htmlspecialchars($row['domain']); ?></td>
                        <td><?php echo htmlspecialchars($row['role_expectations']); ?></td>
                        <td><?php echo htmlspecialchars($row['club_expectations']); ?></td>
                        <td><?php echo htmlspecialchars($row['full_potential']); ?></td>
                        <td><a href="<?php echo htmlspecialchars($row['previous_experience_link']); ?>" target="_blank">View</a></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>

    <script>
    document.querySelectorAll('.app-container-table td').forEach(cell => {
        if (cell.offsetWidth < cell.scrollWidth) {
            cell.classList.add('expandable');
            cell.addEventListener('click', function() {
                this.classList.toggle('expanded');
            });
        }
    });
    </script>

</body>
</html>

<?php
// Free the result set
mysqli_free_result($result);

// Close the database connection
mysqli_close($conn);
?>
