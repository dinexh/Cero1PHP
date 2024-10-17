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
        header("Location: /pages/sidebarOptions/success.php");
        exit();
    } else {
        header("Location: /pages/sidebarOptions/error.php");
        exit();
    }
}
$sql = "SELECT id_number, name, mail, cohort, role FROM users";
$result = mysqli_query($conn, $sql);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>
<html>
<head>
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
                                    <form method="POST" action="/pages/sidebarOptions/view_all_cohorts.php">
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
</body>
</html>
