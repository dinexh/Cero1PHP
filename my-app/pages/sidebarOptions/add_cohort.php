<?php
session_start();
include_once(dirname(__DIR__, 2) . '/db.php'); // Adjust path as needed

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cohort_name = $_POST['cohort_name'];
    $batch = $_POST['batch'];
    $principle = $_POST['principle'];

    // Validate inputs
    if (!empty($cohort_name) && !empty($batch) && !empty($principle)) {
        // Insert into the database
        $query = "INSERT INTO cohorts (cohort_name, batch, principle) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $cohort_name, $batch, $principle);

        if ($stmt->execute()) {
            $status = "success";
        } else {
            $status = "error";
        }
    } else {
        $status = "validation_error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Cohort</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/options.css">
</head>
<body>
    <!-- Toast Notification -->
    <div class="toast" id="toast">
        <?php
        if (isset($status)) {
            if ($status == 'success') {
                echo "Cohort added successfully!";
            } elseif ($status == 'error') {
                echo "Error adding cohort!";
            } elseif ($status == 'validation_error') {
                echo "Please fill in all fields.";
            }
        }
        ?>
    </div>

    <script>
    function showToast(message) {
        const toast = document.createElement('div');
        toast.className = 'toast';
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.classList.add('show');
        }, 100); // Delay to ensure it is visible

        setTimeout(() => {
            toast.classList.remove('show');
            setTimeout(() => {
                document.body.removeChild(toast);
            }, 500); // Time to allow for fade out
        }, 3000); // Duration to keep the toast visible
    }

    // Example of how to use the showToast function
    document.querySelector('form').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent default form submission
        // Call your form submission logic here
        showToast('Cohort added successfully!');
    });
</script>


    <div class="add-container">
        <div class="add-container-in">
            <div class="add-container-in-heading">
                <h1>Add Cohorts</h1>
            </div>
            <div class="add-container-main">
                <div class="add-container-main-one">
                    <form action="" method="POST">
                        <label for="cohort_name">Cohort Name</label>
                        <input type="text" name="cohort_name" id="cohort_name" required>

                        <label for="batch">Batch</label>
                        <select name="batch" id="batch" required>
                            <option value="">---Select Batch---</option>
                            <option value="Y23">Y23</option>
                            <option value="Y24">Y24</option>
                        </select>

                        <label for="principle">Basic Principle of Cohort</label>
                        <input type="text" name="principle" id="principle" required>

                        <button type="submit">Add Cohort!</button>
                    </form>
                </div>

                <div class="add-container-main-two">
                    <h2>Existing Cohorts</h2>
                    <ul>
                        <?php
                        // Fetch existing cohorts from the database
                        $query = "SELECT cohort_name, batch FROM cohorts";
                        $result = $conn->query($query);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<li>" . $row['cohort_name'] . " (" . $row['batch'] . ")</li>";
                            }
                        } else {
                            echo "<li>No cohorts available</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
