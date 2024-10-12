<?php
session_start();
define('BASE_PATH', __DIR__ . '/../../'); // Set a base path for includes

$dashnavPath = BASE_PATH . "includes/dashnav.php"; // Use the base path

if (file_exists($dashnavPath)) {
    include $dashnavPath;
} else {
    echo "Navigation file not found."; // Error message if the file is not found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Core | ZeroOne Portal</title>
</head>
<body>
    <div class="dash">
        <div class="dash-in">
            <div class="dash-nav">
                <!-- Only include the navigation here, since you've already included it earlier -->
            </div>
        </div>
    </div>
</body>
</html>
