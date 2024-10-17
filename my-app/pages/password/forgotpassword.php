<?php
include_once(dirname(__DIR__, 2) . '/config.php'); 
require_once '../../config.php';

$id_number = $name = $mail = $cohort = $message_code = $new_password = $confirm_password = '';
$step = 1; 
$success = $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['verify_user'])) {
        // Step 1: User verification
        $id_number = trim($_POST['id_number']);
        $name = trim($_POST['name']);
        $mail = trim($_POST['mail']);
        $cohort = trim($_POST['cohort']);
        $message_code = trim($_POST['message_code']);

        // Validate input
        if (empty($id_number) || empty($name) || empty($mail) || empty($cohort) || empty($message_code)) {
            $error = 'All fields are required for verification.';
        } else {
            // Connect to the database
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) {
                $error = 'Database connection failed: ' . $conn->connect_error;
            } else {
                // Verify user information and message/code
                $sql = "SELECT * FROM users WHERE id_number = ? AND name = ? AND mail = ? AND cohort = ? AND message_code = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param('sssss', $id_number, $name, $mail, $cohort, $message_code);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 0) {
                    $error = 'User not found or details do not match.';
                } else {
                    // Move to step 2: password reset
                    $step = 2;
                }
                $stmt->close();
            }
            $conn->close();
        }
    } elseif (isset($_POST['reset_password'])) {
        // Step 2: Password reset
        $id_number = trim($_POST['id_number']);
        $new_password = trim($_POST['new_password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (empty($new_password) || empty($confirm_password)) {
            $error = 'All password fields are required.';
        } elseif ($new_password !== $confirm_password) {
            $error = 'New password and confirmation do not match.';
        } else {
            // Connect to the database
            $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            if ($conn->connect_error) {
                $error = 'Database connection failed: ' . $conn->connect_error;
            } else {
                // Update the password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_sql = "UPDATE users SET password = ? WHERE id_number = ?";
                $update_stmt = $conn->prepare($update_sql);
                $update_stmt->bind_param('ss', $hashed_password, $id_number);

                if ($update_stmt->execute()) {
                    $success = 'Password updated successfully!';
                    $id_number = $name = $mail = $cohort = $new_password = $confirm_password = ''; // Reset fields
                } else {
                    $error = 'Error updating password: ' . $update_stmt->error;
                }
                $update_stmt->close();
            }
            $conn->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="forgotpassword.css">
</head>
<body>
    <div class="forgot-container">
        <div class="forgot-container-in">
            <div class="forgot-container-heading">
                <h1>Zero<span>One</span> Portal</h1>
                <h2>Forgot Password</h2>
            </div>
            <div class="forgot-container-indication">
                <?php if ($success): ?>
                <div class="success-message"><?php echo $success; ?></div>
                <?php elseif ($error): ?>
                <div class="error-message"><?php echo $error; ?></div>
                <?php endif; ?>

                <?php if ($step === 1): ?>
            </div>
            <div class="forgot-form">  
                <form method="POST" action="" class="form-verify">
                    <div class="form-group">
                        <label for="id_number" class="form-label">ID Number:</label>
                        <input type="text" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="mail" class="form-label">Email:</label>
                        <input type="email" id="mail" name="mail" value="<?php echo htmlspecialchars($mail); ?>" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="cohort" class="form-label">Cohort:</label>
                        <input type="text" id="cohort" name="cohort" value="<?php echo htmlspecialchars($cohort); ?>" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="message_code" class="form-label">Message/Code:</label>
                        <input type="text" id="message_code" name="message_code" value="<?php echo htmlspecialchars($message_code); ?>" required class="form-input">
                    </div>

                    <button type="submit" name="verify_user" class="form-button">Verify</button>
                    <div class="loader" id="loader"></div>
                </form>
            </div>

            <?php elseif ($step === 2): ?>
            <!-- Step 2: Password Reset Form -->
            <div class="forgot-form">
                <form method="POST" action="" class="form-reset">
                    <input type="hidden" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>">

                    <div class="form-group">
                        <label for="new_password" class="form-label">New Password:</label>
                        <input type="password" id="new_password" name="new_password" required class="form-input">
                    </div>

                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirm New Password:</label>
                        <input type="password" id="confirm_password" name="confirm_password" required class="form-input">
                    </div>

                    <button type="submit" name="reset_password" class="form-button">Reset Password</button>
                </form>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <script>
        // Add loader visibility during form submission (Step 1)
        document.querySelector('form').addEventListener('submit', function() {
            document.getElementById('loader').classList.add('show');
        });
    </script>
</body>
</html>
