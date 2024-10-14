<?php
require_once(__DIR__ . '/../../../config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register for Event</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>includes/style.css">
</head>
<body>
    <h1>Register for Event</h1>
    <form action="submit_event_registration.php" method="POST">
        <label for="event_name">Event Name:</label>
        <input type="text" id="event_name" name="event_name" required>
        
        <label for="event_date">Event Date:</label>
        <input type="date" id="event_date" name="event_date" required>

        <button type="submit">Register</button>
    </form>
</body>
</html>
