<?php
require_once(__DIR__ . '/../../../config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raise Ticket</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>includes/style.css">
</head>
<body>
    <h1>Raise Ticket</h1>
    <form action="submit_ticket.php" method="POST">
        <label for="issue">Issue Description:</label>
        <textarea id="issue" name="issue" required></textarea>
        
        <button type="submit">Submit Ticket</button>
    </form>
</body>
</html>
