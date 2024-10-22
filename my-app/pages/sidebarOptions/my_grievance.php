<?php
session_start();
require_once('../../db.php');

$response = array('success' => false, 'message' => '');

// Make sure the user is logged in
if (!isset($_SESSION['id_number'])) {
    $response['message'] = 'You must be logged in to view grievances.';
    echo json_encode($response);
    exit();
}

// Get the user ID from the session
$id_number = mysqli_real_escape_string($conn, $_SESSION['id_number']);

// Update your SQL query
$sql = "SELECT * FROM grievances WHERE user_id_number = '$id_number'";
$result = mysqli_query($conn, $sql);

if ($result) {
    $grievances = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $response['success'] = true;
    $response['data'] = $grievances;
} else {
    $response['message'] = "Database Error: " . mysqli_error($conn);
}

// If you want to display the grievances in a table
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Grievances</title>
    <!-- <link rel="stylesheet" href="/pages/sidebarOptions/greivance.css">  -->
    <link rel="stylesheet" href="/pages/sidebarOptions/my_grievance.css">

</head>
<body>
    <div class="grievance-container">
        <h1>My Grievances</h1>
        <?php if ($response['success'] && !empty($response['data'])): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Grievance Text</th>
                        <th>Status</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($response['data'] as $grievance): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($grievance['id']); ?></td>
                            <td><?php echo htmlspecialchars($grievance['user_id_number']); ?></td>
                            <td><?php echo htmlspecialchars($grievance['grievance_text']); ?></td>
                            <td><?php echo htmlspecialchars($grievance['status']); ?></td>
                            <td><?php echo htmlspecialchars($grievance['created_at']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No grievances found.</p>
        <?php endif; ?>
    </div>
</body>
</html>
