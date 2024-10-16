<?php
session_start();
require_once('../../db.php'); 
$response = array('success' => false, 'message' => '');

if (!isset($_SESSION['id_number'])) {
    $response['message'] = 'You must be logged in to submit feedback.';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = mysqli_real_escape_string($conn, $_SESSION['id_number']);
    $event_name = mysqli_real_escape_string($conn, $_POST['event_name']);
    $domain_of_event = mysqli_real_escape_string($conn, $_POST['domain_of_event']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $event_date = date('Y-m-d');
    $concept_rating = mysqli_real_escape_string($conn, $_POST['concept_rating']);
    $mentorship_rating = mysqli_real_escape_string($conn, $_POST['mentorship_rating']);

    // Insert feedback into database
    $sql = "INSERT INTO feedback (user_id, event_name, message, event_date, concept_rating, mentorship_rating, domain_of_event) 
            VALUES ('$id_number', '$event_name', '$message', '$event_date', '$concept_rating', '$mentorship_rating', '$domain_of_event')";

    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = "Feedback submitted successfully!";
    } else {
        $response['message'] = "Database Error: " . mysqli_error($conn);
    }
    echo json_encode($response);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submit Feedback</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/feedback.css"> 
</head>
<body>
    <div class="feedback-container">
        <div class="feedback-container-in">
            <div class="feedback-heading">
                <h1>Submit Feedback</h1>
            </div>
            <div class="feedback-form-container">
                <form id="feedbackForm" class="feedback-form" method="POST" action="/pages/sidebarOptions/add_feedback.php">
                    <div class="form-group">
                    <label for="event_name">Event Name:</label>
                    <input type="text" name="event_name" required>
                    </div>
                    <div class="form-group">
                        <label for="domain_of_event">Domain of Event:</label>
                        <input type="text" name="domain_of_event" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea name="message" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="concept_rating">Concept Rating:</label>
                        <input type="number" name="concept_rating" min="1" max="5" required>
                    </div>
                    <div class="form-group">
                        <label for="mentorship_rating">Mentorship Rating:</label>
                        <input type="number" name="mentorship_rating" min="1" max="5" required>
                    </div>
                    <div class="form-button">
                        <button type="submit">Submit Feedback</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="response"></div>
    <script>
        document.getElementById('feedbackForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent normal form submission
            var formData = new FormData(this);
            fetch('add_feedback.php', {
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
