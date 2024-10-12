<?php
session_start();
if(!isset($_SESSION['id_number']))
{
    header('Location: /index.php');
}
$dashnavPath = __DIR__ . '/../../../includes/dashnav.php'; 
$footerPath = __DIR__ . '/../../../includes/footer.php';   
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
