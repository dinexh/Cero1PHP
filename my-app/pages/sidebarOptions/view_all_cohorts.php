<?php
session_start();
require_once('../../db.php');

// Handle role change using POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_number'], $_POST['new_role'])) {
    $id_number = mysqli_real_escape_string($conn, $_POST['id_number']);
    $new_role = mysqli_real_escape_string($conn, $_POST['new_role']);

    // Update the user's role in the database
    $update_sql = "UPDATE users SET role = '$new_role' WHERE id_number = '$id_number'";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: view_all_cohorts.php?status=success&message=Role updated successfully!");
        exit();
    } else {
        header("Location: view_all_cohorts.php?status=error&message=Error updating role: " . mysqli_error($conn));
        exit();
    }
}

// Fetch all cohorts from the database
$sql = "SELECT id_number, name, mail, cohort, role FROM users";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View All Cohorts</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/options.css">
</head>
<body>
    <div class="view-container">
        <div class="view-container-in">
            <div class="view-container-heading">
                <h2>All Cohorts</h2>
            </div>

            <div class="view-container-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Cohort</th>
                            <th>Current Role</th>
                            <th>Change Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['mail']); ?></td>
                                <td><?php echo htmlspecialchars($row['cohort']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td>
                                    <form method="POST" action="view_all_cohorts.php">
                                        <input type="hidden" name="id_number" value="<?php echo htmlspecialchars($row['id_number']); ?>">
                                        <select name="new_role">
                                            <option value="club_member" <?php echo ($row['role'] == 'club_member') ? 'selected' : ''; ?>>Club Member</option>
                                            <option value="club_core" <?php echo ($row['role'] == 'club_core') ? 'selected' : ''; ?>>Club Core</option>
                                            <option value="DSIOG" <?php echo ($row['role'] == 'DSIOG') ? 'selected' : ''; ?>>DSIOG</option>
                                        </select>
                                        <button type="submit">Change Role</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="toaster" class="toaster"></div>

    <script>
        // Display toaster message if status and message are present in the URL
        const params = new URLSearchParams(window.location.search);
        const status = params.get('status');
        const message = params.get('message');

        if (status && message) {
            const toaster = document.getElementById('toaster');
            toaster.innerText = message;
            toaster.style.display = 'block';
            toaster.style.backgroundColor = status === 'success' ? 'green' : 'red';

            // Automatically hide the toaster after 3 seconds
            setTimeout(() => {
                toaster.style.display = 'none';
            }, 3000);
        }
    </script>
</body>
</html>
