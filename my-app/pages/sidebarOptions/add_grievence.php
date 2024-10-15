<?php
session_start();
require_once('../../config.php'); // Ensure this file contains your database connection settings
require_once('../../db.php'); // Make sure this file connects to your database

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $grievance_date = mysqli_real_escape_string($conn, $_POST['grievance_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $option = mysqli_real_escape_string($conn, $_POST['option']);
    
    // Insert into database (no need to insert id_number as it's auto-incremented)
    $sql = "INSERT INTO grievances (grievance_date, description, `option`, ongoing, result) 
            VALUES ('$grievance_date', '$description', '$option', 1, 'Pending')";

    if (mysqli_query($conn, $sql)) {
        // Redirect to a different page on success
        header("Location: confirmation.php"); // Change to your desired page
        exit(); // Ensure no further code is executed after redirection
    } else {
        error_log("Database Error: " . mysqli_error($conn)); // Log the error for debugging
        // Optionally, you can redirect to an error page or display an error message
        header("Location: error.php"); // Change to your error handling page
        exit();
    }
}
?>

<html>
<head>
    <title>Add Grievance</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/greivence.css">
</head>
<body>
    <div class="gre-container">
        <div class="gre-container-in">
            <div class="gre-container-heading">
                <h1>Add a Grievance</h1>
            </div>
            <div class="gre-container-form">
                <form class="add-grievance-form" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <label for="grievance_date">Grievance Date:</label>
                    <input type="date" id="grievance_date" name="grievance_date" required>

                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>

                    <label for="option">Option:</label>
                    <select id="option" name="option" required>
                        <option value="general">General</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="complaint">Complaint</option>
                    </select>

                    <button type="submit">Submit Grievance</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
