<?php
require_once('../../db.php'); 

// Query to fetch all grievances
$query = "SELECT * FROM grievances";  
$result = mysqli_query($conn, $query);

// Handle form submission to resolve grievance
if (isset($_POST['end_grievance'])) {
    $grievance_id = $_POST['id'];

    // Update the grievance status in the database
    $query = "UPDATE grievances SET ongoing = 0, result = 'Resolved' WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'i', $grievance_id);
    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
        $response['message'] = "Grievance resolved successfully!";
    } else {
        $response['message'] = "Error resolving grievance.";
    }
    echo json_encode($response);
    exit();
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
                        <th>Domain</th>
                        <th>Information</th>
                        <th>Date Reported</th>
                        <th>Ongoing</th>
                        <th>Result</th>
                        <th>Action</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['user_id'] . '</td>';
                        echo '<td>' . $row['domain'] . '</td>';
                        echo '<td>' . $row['information'] . '</td>';
                        echo '<td>' . $row['date_reported'] . '</td>';
                        echo '<td>' . ($row['ongoing'] == 1 ? 'Yes' : 'No') . '</td>';
                        echo '<td>' . $row['result'] . '</td>';
                        echo '<td>';
                        if ($row['ongoing'] == 1) {
                            echo '<form method="POST" action="/pages/sidebarOptions/grievance_stats.php">';
                            echo '<input type="hidden" name="id" value="' . $row['id'] . '">';
                            echo '<button type="submit" name="end_grievance">End Grievance</button>';
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
    <div id="response"></div>
    <script>
        document.getElementById('grievanceForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent normal form submission
            var formData = new FormData(this);
            fetch('/pages/sidebarOptions/grievance_stats.php', {  // Correct the fetch path
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').innerText = data.message;
                if (data.success) {
                    this.reset(); // Clear the form if successful
                }
            })
            .catch(error => console.error('Error:', error));
        };
    </script>
</body>
</html>
