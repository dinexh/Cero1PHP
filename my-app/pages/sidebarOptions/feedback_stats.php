<?php
require_once('../../db.php'); 
$query = "SELECT * FROM feedback";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - View Feedback</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/feedback.css"> 
</head>
<body>
    <div class="feedback-container">
        <div class="feedback-container-in">
            <div class="feedback-container-heading">
                <h1>All Feedback Submissions</h1>
            </div>
            <div class="feedback-container-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User ID</th>
                        <th>Event Name</th>
                        <th>Domain of Event</th>
                        <th>Concept Rating</th>
                        <th>Mentorship Rating</th>
                        <th>Message</th>
                        <th>Event Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    require_once('../../db.php'); 
                    $query = "SELECT * FROM feedback";
                    $result = mysqli_query($conn, $query);
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['user_id'] . '</td>';
                        echo '<td>' . $row['event_name'] . '</td>';
                        echo '<td>' . $row['domain_of_event'] . '</td>';
                        echo '<td>' . $row['concept_rating'] . '</td>';
                        echo '<td>' . $row['mentorship_rating'] . '</td>';
                        echo '<td>' . $row['message'] . '</td>';
                        echo '<td>' . $row['event_date'] . '</td>';
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
