<?php
require_once('../../db.php'); 

// Handle form submission to resolve grievance
if (isset($_POST['end_grievance'])) {
    $grievance_id = $_POST['id'];

    // Update the grievance status in the database
    $query = "UPDATE grievances SET status = 'resolved' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $grievance_id);

    if (mysqli_stmt_execute($stmt)) {
        // Redirect to success page
        header('Location: /pages/sidebarOptions/success.php'); // Change to your success page path
        exit();
    } else {
        // If there's an error, redirect to error page
        header('Location: /pages/sidebarOptions/error.php');  // Change to your error page path
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Grievances</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/greivance.css"> 
</head>
<body>
    <div class="gre-container">
        <div class="gre-container-in">
            <div class="gre-container-heading">
                <h1>All Grievance Submissions</h1>
            </div>
            <div class="gre-container-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Grievance Text</th>
                        <th>Date Reported</th>
                        <th>Status</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Query to fetch all grievances
                    $query = "SELECT * FROM grievances";  
                    $result = mysqli_query($conn, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['user_id_number'] . '</td>';
                        echo '<td>' . $row['grievance_text'] . '</td>';
                        echo '<td>' . $row['created_at'] . '</td>';
                        echo '<td>' . $row['status'] . '</td>';
                        echo '<td>';
                        if ($row['status'] == 'pending') {
                            echo '<form method="POST" action="/pages/sidebarOptions/grievance_stats.php">';
                            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                            echo '<button type="submit" name="end_grievance">Resolve Grievance</button>';
                            echo '</form>';
                        } else {
                            echo 'No action needed';
                        }
                        echo '</td>';
                        echo '</tr>';
                    }
                    ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</body>
</html>
