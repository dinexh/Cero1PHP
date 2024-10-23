<?php
require_once('../../db.php');

// Initialize variables
$user = null;
$message = "";

// Handle user search
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['search'])) {
    $search_term = trim($_POST['search_term']);

    // Prepare the SQL statement to search for users
    $stmt = $conn->prepare("SELECT * FROM users WHERE id_number = ? OR name LIKE ?");
    $like_search = "%" . $search_term . "%";
    $stmt->bind_param("ss", $search_term, $like_search);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Fetch the user details
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        $message = "No user found with that ID or name.";
    }
}

// Handle user deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $id_number = $_POST['id_number'];

    // Prepare the SQL statement to delete the user
    $stmt = $conn->prepare("DELETE FROM users WHERE id_number = ?");
    $stmt->bind_param("s", $id_number);

    if ($stmt->execute()) {
        $message = "User successfully terminated.";
        $user = null; // Clear user details
    } else {
        $message = "Error terminating user: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Terminate Users</title>
    <style>
        .message {
            color: red;
            font-weight: bold;
        }
        .user-details {
            margin-top: 20px;
            padding: 10px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Terminate User</h1>
        <form action="/pages/sidebarOptions/termination.php" method="POST">
            <label for="search_term">Search User by ID or Name:</label>
            <input type="text" name="search_term" id="search_term" required>
            <button type="submit" name="search">Search</button>
        </form>

        <?php if ($message): ?>
            <div class="message"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($user): ?>
            <div class="user-details">
                <h2>User Details</h2>
                <p>ID Number: <?php echo htmlspecialchars($user['id_number']); ?></p>
                <p>Name: <?php echo htmlspecialchars($user['name']); ?></p>
                <p>Email: <?php echo htmlspecialchars($user['mail']); ?></p>
                <p>Cohort: <?php echo htmlspecialchars($user['cohort']); ?></p>
                <p>Role: <?php echo htmlspecialchars($user['role']); ?></p>
                
                <form action="/pages/sidebarOptions/termination.php" method="POST">
                    <input type="hidden" name="id_number" value="<?php echo htmlspecialchars($user['id_number']); ?>">
                    <button type="submit" name="delete">Terminate User</button>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
