<?php
// Include the db.php file
include_once(dirname(__DIR__, 2) . '/db.php'); // Adjust the path as needed

if ($conn) {
    // Your database query here
    $query = "SELECT * FROM users"; // Example query
    $result = $conn->query($query);

    if (!$result) {
        echo "Error executing query: " . $conn->error;
        exit; // Stop execution on error
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cohort Management</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/options.css">
    <style>
        /* Your existing toast styles */
    </style>
</head>
<body>
    <div class="toast" id="toast">
        <?php
        // Check for status parameter
        if (isset($_GET['status'])) {
            if ($_GET['status'] == 'success') {
                echo "Role updated successfully!";
            } elseif ($_GET['status'] == 'error') {
                echo "Error updating role!";
            }
        }
        ?>
    </div>

    <script>
        // Show toast if there's a message
        window.onload = function() {
            const toast = document.getElementById("toast");
            if (toast.textContent.trim() !== "") {
                toast.classList.add("show");
                setTimeout(function() {
                    toast.classList.remove("show");
                }, 3000); // Show for 3 seconds
            }
        };
    </script>

    <div class="view-container">
        <div class="view-container-in">
            <div class="view-container-heading">
                <h2>Cohort Management</h2>
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
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo $row['id_number']; ?></td>
                                <td><?php echo $row['name']; ?></td>
                                <td><?php echo $row['mail']; ?></td>
                                <td><?php echo $row['cohort']; ?></td>
                                <td><?php echo $row['role']; ?></td>
                                <td>
                                    <form action="/pages/sidebarOptions/DSIOG/change_role.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $row['id']; ?>">
                                        <select name="new_role">
                                            <option value="club_member" <?php echo ($row['role'] == 'club_member') ? 'selected' : ''; ?>>Club Member</option>
                                            <option value="club_core" <?php echo ($row['role'] == 'club_core') ? 'selected' : ''; ?>>Club Core</option>
                                            <option value="DSIOG" <?php echo ($row['role'] == 'DSIOG') ? 'selected' : ''; ?>>DSIOG</option>
                                        </select>
                                </td>
                                <td>
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
