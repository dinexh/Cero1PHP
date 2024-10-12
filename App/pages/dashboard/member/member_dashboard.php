<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$dashnavPath = __DIR__ . '/../../../includes/dashnav.php'; // For dashnav
$footerPath = __DIR__ . '/../../../includes/footer.php';   // Correct path for footer
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Dashboard | ZeroOne Portal</title>
</head>
<body>
    <div class="dash">
        <div class="dash-in">
            <div class="dash-nav">
                <?php include $dashnavPath; ?>
            </div>
            <div class="dash-main">
                This is the Member Dashboard
            </div>
            <div class="dash-footer">
                <footer>
                    <?php include $footerPath; ?>
                </footer>
            </div>
        </div>
    </div>
</body>
</html>
