<?php
session_start();
require_once('../../db.php'); 
$response = array('success' => false, 'message' => '');

if (!isset($_SESSION['id_number'])) {
    $response['message'] = 'You must be logged in to submit a grievance.';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = mysqli_real_escape_string($conn, $_SESSION['id_number']);
    $grievance_text = mysqli_real_escape_string($conn, $_POST['information']); // Use 'information' for grievance text
    $status = 'pending'; // Default status
    $grievance_date = date('Y-m-d H:i:s');

    // Insert grievance into the database
    $sql = "INSERT INTO grievances (user_id_number, grievance_text, status, created_at) 
            VALUES ('$id_number', '$grievance_text', '$status', '$grievance_date')";

    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = "Grievance submitted successfully!";
    } else {
        $response['message'] = "Database Error: " . mysqli_error($conn);
    }
    echo json_encode($response);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Grievance</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/greivance.css"> 
</head>
<body>
    <div class="gre-container">
        <div class="gre-container-in">
            <div class="gre-container-in-heading">
                <h1>Submit a Grievance</h1>
            </div>
            <div class="gre-container-form" >
                <form id="grievanceForm" class="gre-grievance-form " method="POST" action="/pages/sidebarOptions/add_grievance.php">
                    <label for="domain">Domain:</label>
                    <input type="text" name="domain" required>
                    <br>
                    <label for="information">Information:</label>
                    <textarea name="information" required></textarea>
                    <br>
                    <div class="form-button">
                        <button type="submit">Submit Grievance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="response"></div>
    <script>
        document.getElementById('grievanceForm').onsubmit = function(event) {
            event.preventDefault(); // Prevent normal form submission
            var formData = new FormData(this);
            fetch('add_grievance.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                document.getElementById('response').innerText = data.message;
                if (data.success) {
                    this.reset(); // Clear the form if successful
                }
            })
            .catch(error => console.error('Error:', error));
        };
    </script>
</body>
</html>
