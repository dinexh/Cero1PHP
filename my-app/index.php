<?php
session_start();
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
    <div class="landing-container">
        <div class="landing-container-in">
            <div class="landing-nav">
                <?php include "./includes/nav.php"; ?>
            </div>
            <div class="landing-main-container">
                <div class="landing-main-container-in">
                    <div class="landing-main-container-in-one">
                        <img src="./assets/Team_Work.jpg" alt="landing page images">
                    </div>
                    <div class="landing-main-container-in-two">
                        <div class="form-container">
                            <div class="form-heading">
                                <h2>ZeroOne Portal</h2>
                                <p>Build Create Inspire Transform</p>
                            </div>
                            <form action="/auth/login.php" method="post">
                                <div class="input-group">
                                    <label for="username">Username</label>
                                    <input type="text" id="username" name="username"  required>
                                </div>
                                <div class="input-group">
                                    <label for="password">Password</label>
                                    <input type="password" id="password" name="password" required>
                                </div>
                                <div class="input-group">
                                    <button type="submit">Login</button>
                                </div>
                                <div class="forgot-password">
                                    <a href="/pages/password/forgotpassword.php">Forgot password?</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="landing-footer">
                <?php include "./includes/footer.php"; ?>
            </div>
        </div>
    </div>
</body>
</html>
