<?php
?>
<link rel="stylesheet" href="./global.css"> 
<div class="dashnav">
    <div class="dashnav-in">
        <div class="dashnav-in-one">
            <h1>Zero<span>One</span>Portal</h1>
        </div>
        <div class="dashnav-in-two">
            <p><?php echo $_SESSION['id_number']; ?> / <?php echo $_SESSION['name']; ?> / <?php echo $_SESSION['role']; ?></p>
            <a href="/logout.php">Logout</a>
        </div>
    </div>
</div>
<style>
    .dashnav {
    width: 100%;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: black;
    color: white;
}

.dashnav-in {
    padding: 0.5rem;
    width: 95%;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.dashnav-in-one h1 {
    font-size: 1.6rem;
    font-weight: 500;
    color: white;
}

.dashnav-in-one span {
    color: blue;
    font-size: 1.6rem;
    font-weight: 500;
}

.dashnav-in-two-in p {
    font-size: 1.1rem;
    font-weight: 400;
    color: white;
    padding: 0.4rem;
}
</style>