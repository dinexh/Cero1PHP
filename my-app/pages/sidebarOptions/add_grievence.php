<?php
session_start();
require_once('../../config.php'); 
require_once('../../db.php'); 

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $grievance_date = mysqli_real_escape_string($conn, $_POST['grievance_date']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $option = mysqli_real_escape_string($conn, $_POST['option']);
    
    $sql = "INSERT INTO grievances (grievance_date, description, `option`, ongoing, result) 
            VALUES ('$grievance_date', '$description', '$option', 1, 'Pending')";

    if (mysqli_query($conn, $sql)) {
        $response['success'] = true;
        $response['message'] = "Grievance submitted successfully!";
    } else {
        $response['message'] = "Database Error: " . mysqli_error($conn);
    }
    
    // Return response as JSON
    echo json_encode($response);
    exit();
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
                <form class="add-grievance-form" id="grievanceForm" method="POST">
                    <label for="grievance_date">Grievance Date:</label>
                    <input type="date" id="grievance_date" name="grievance_date" required>
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" required></textarea>
                    <label for="option">Categories:</label>
                    <select id="option" name="option" required>
                        <option value="general">General</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="complaint">Complaint</option>
                    </select>
                    <div class="form-button">
                        <button type="submit">Submit Grievance</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Toast Notification -->
    <div id="toast" class="toast"></div>

    <script>
        document.getElementById('grievanceForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            const formData = new FormData(this);

            fetch('<?php echo $_SERVER['PHP_SELF']; ?>', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                const toast = document.getElementById('toast');
                toast.textContent = data.message;
                toast.className = 'toast show'; // Show the toast
                
                // Hide the toast after 3 seconds
                setTimeout(() => {
                    toast.className = 'toast';
                }, 3000);
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    </script>
</body>
</html>
