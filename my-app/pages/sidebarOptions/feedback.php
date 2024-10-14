<?php
require_once(__DIR__ . '/../../../config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>includes/style.css">
</head>
<body>
    <h1>Feedback</h1>
    <form action="submit_feedback.php" method="POST">
        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" required></textarea>
        
        <button type="submit">Submit Feedback</button>
    </form>
</body>
</html>
