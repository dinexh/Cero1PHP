<?php
session_start();
require_once('../../db.php'); 
if (!isset($_SESSION['id_number'])) {
    header("Location: /auth/login.php"); 
    exit();
}
$id_number = mysqli_real_escape_string($conn, $_SESSION['id_number']);
$sql = "SELECT user_id, event_name, message, event_date , concept_rating , mentorship_rating , domain_of_event FROM feedback WHERE user_id = '$id_number'";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grievances</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/feedback.css"> 
</head>
<body>
    <div class="feedback-container">
        <div class="feedback-container-in">
            <div class="feedback-container-in-heading">
                <h1>My Feedbacks</h1>
            </div>
            <div class="feedback-container-table">
                <table>
                    <thead>
                        <tr>
                            <th>User ID</th>
                            <th>Event Name</th>
                            <th>Event Date</th>
                            <th>Concept Rating</th>
                            <th>Mentorship Rating</th>
                            <th>Domain of Event</th>
                            <th>Message</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['user_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['event_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['event_date']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['concept_rating']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['mentorship_rating']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['domain_of_event']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['message']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No feedbacks found</td></tr>";
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
