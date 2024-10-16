<?php
include_once(dirname(__DIR__, 2) . '/db.php');
$message = ''; // Initialize message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    error_log('POST request received');

    if (isset($_POST['user_id']) && isset($_POST['new_role'])) {
        $user_id = intval($_POST['user_id']);
        $new_role = trim($_POST['new_role']);
        
        error_log("User ID: $user_id, New Role: $new_role"); // Log the received values

        // Fetch current role
        $stmt = $conn->prepare("SELECT role FROM users WHERE id = ?");
        if (!$stmt) {
            error_log("Error preparing statement: " . $conn->error);
            echo 'Error preparing statement';
            exit;
        }

        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows === 0) {
            $message = 'User not found!';
            error_log($message);
        } else {
            $current_role = $result->fetch_assoc()['role'];
            error_log("Current role: $current_role"); // Log the current role

            if ($current_role === $new_role) {
                $message = 'No changes made. Role was already selected.';
                error_log($message);
            } else {
                // Update role
                $sql = "UPDATE users SET role = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param('si', $new_role, $user_id);
                    if ($stmt->execute()) {
                        if ($stmt->affected_rows > 0) {
                            $message = 'Role updated successfully!';
                            error_log($message);
                        } else {
                            $message = 'No changes made. Role was already selected.';
                            error_log($message);
                        }
                    } else {
                        $message = 'Error updating role: ' . $stmt->error;
                        error_log('SQL Error: ' . $stmt->error);
                    }
                } else {
                    $message = 'Error preparing statement: ' . $conn->error;
                    error_log($message);
                }
            }
        }
    } else {
        $message = 'User ID or new role not set!';
        error_log($message);
    }

    echo $message; // Send message back to AJAX
    exit;
}

// Fetch all users
$stmt = $conn->prepare("SELECT id, id_number, name, mail, cohort, role FROM users");
if (!$stmt) {
    die("Preparation Error: " . $conn->error); // Log preparation error
}

$stmt->execute();
$result = $stmt->get_result();

if (!$result) {
    die("Query Error: " . $conn->error); // Display an error message if the query fails
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cohort Management</title>
    <link rel="stylesheet" href="/pages/sidebarOptions/options.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <!-- Status Message -->
    <div class="status-message"><?php echo htmlspecialchars($message); ?></div>

    <div class="view-container">
        <div class="view-container-in">
            <div class="view-container-heading">
                <h2>Cohort Management</h2>
            </div>

            <div class="view-container-table">
                <table>
                    <thead>
                        <tr>
                            <th>ID Number</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Cohort</th>
                            <th>Current Role</th>
                            <th>Change Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['mail']); ?></td>
                                <td><?php echo htmlspecialchars($row['cohort']); ?></td>
                                <td><?php echo htmlspecialchars($row['role']); ?></td>
                                <td>
                                    <form class="role-change-form" data-user-id="<?php echo htmlspecialchars($row['id']); ?>">
                                        <select name="new_role">
                                            <option value="club_member" <?php echo ($row['role'] == 'club_member') ? 'selected' : ''; ?>>Club Member</option>
                                            <option value="club_core" <?php echo ($row['role'] == 'club_core') ? 'selected' : ''; ?>>Club Core</option>
                                            <option value="DSIOG" <?php echo ($row['role'] == 'DSIOG') ? 'selected' : ''; ?>>DSIOG</option>
                                        </select>
                                        <button type="submit">Change Role</button>
                                    </form>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script>
        $(document).ready(function() {
            console.log('Document ready - jQuery is working'); // Confirm jQuery is working
            
            $('.role-change-form').on('submit', function(e) {
                e.preventDefault(); // Prevent form submission

                var userId = $(this).data('user-id'); // Fetch user ID from form data
                var newRole = $(this).find('select[name="new_role"]').val(); // Get selected new role

                console.log('Form submission detected'); // Confirm form submission detection
                console.log('User ID:', userId); // Log the user ID
                console.log('New Role:', newRole); // Log the new role

                // Send AJAX request
                $.ajax({
                    url: '', // Current PHP file will handle the request
                    type: 'POST',
                    data: {
                        user_id: userId,
                        new_role: newRole
                    },
                    success: function(response) {
                        console.log('AJAX request successful'); // Log AJAX success
                        console.log('Server response:', response); // Log the response from the server

                        // Display the server message in the status message div
                        $('.status-message').text(response); 
                    },
                    error: function(xhr, status, error) {
                        console.log('AJAX request failed'); // Log AJAX failure
                        console.log('Status:', status); // Log status
                        console.log('Error:', error); // Log error

                        // Display a generic error message
                        $('.status-message').text('Error updating role. Please try again.');
                    }
                });
            });
        });
    </script>

    <?php $conn->close(); ?>
</body>
</html>
