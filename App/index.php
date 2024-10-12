<?php
session_start();
include "./includes/nav.php"; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZeroOne Portal</title>
    <link rel="stylesheet" href="global.css">
</head>
<body>
    <div class="land">
        <div class="land-in">
            <div class="land-nav">
                <nav>
                </nav>
            </div>
            <div class="land-main">
                <div class="land-main-in">
                    <div class="land-main-in-one">
                        <div class="land-main-in-one-img">
                            <img src="./assets/Team_Work.jpg" alt="Team Work Image">
                        </div>
                    </div>
                    <div class="land-main-in-two">
                        <div class="land-main-in-two-in">
                            <div class="land-main-in-two-in-heading">
                                <h1>ZeroOne Portal</h1>
                                <p>Build Create Inspire Transform</p>
                            </div>
                            <div class="land-main-in-form">
                                <form action ="login.php" method="post">
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="text" name="username" id="username" placeholder="Username" required />
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" name="password" id="password" placeholder="Password" required />
                                    </div>
                                    <div class="form-group-button">
                                        <button type="submit">Login</button>
                                    </div>
                                    <div class="form-group-password">
                                        <p>Forgot password?</p>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="land-footer">
            <footer>
                <?php include "./includes/footer.php"; ?>
            </footer>
        </div>
    </div>
</body>
</html>
