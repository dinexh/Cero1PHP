<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$id_number = isset($_SESSION['id_number']) ? $_SESSION['id_number'] : 'Unknown ID';
$name = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown Name'; 
$role = isset($_SESSION['role']) ? $_SESSION['role'] : 'Unknown Role';
?>
<link rel="stylesheet" href="../../includes/dashnav.css">
<div class="dashnav">
    <div class="dashnav-in">
        <div class="dashnav-in-one">
            <h1>Zero<span>One</span> Portal</h1>
        </div>
        <div class="dashnav-in-two">
            <p><?php echo $id_number; ?> / <?php echo $name; ?> / <?php echo $role; ?></p>
            <a href="../../auth/logout.php">Logout</a>
        </div>
    </div>
</div>
