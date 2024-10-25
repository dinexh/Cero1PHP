<?php
require_once('../../db.php');
require_once '../../config.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate input data
    $name = htmlspecialchars(trim($_POST['name']));
    $id_number = htmlspecialchars(trim($_POST['id_number']));
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $domain = htmlspecialchars(trim($_POST['domain']));
    $role_expectations = htmlspecialchars(trim($_POST['role_expectations']));
    $club_expectations = htmlspecialchars(trim($_POST['club_expectations']));
    $full_potential = htmlspecialchars(trim($_POST['full_potential']));
    $previous_experience_link = filter_var($_POST['previous_experience_link'], FILTER_VALIDATE_URL);

    if ($email && $previous_experience_link !== false) {
        // Prepare SQL query
        $query = "INSERT INTO core_team_applications (name, id_number, email, phone, domain, role_expectations, club_expectations, full_potential, previous_experience_link)
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);

        // Bind parameters
        mysqli_stmt_bind_param($stmt, 'sssssssss', $name, $id_number, $email, $phone, $domain, $role_expectations, $club_expectations, $full_potential, $previous_experience_link);

        // Execute and check if successful
        if (mysqli_stmt_execute($stmt)) {
            header('Location: /pages/sidebarOptions/success.php');
            exit();
        } else {
            header('Location: /pages/sidebarOptions/error.php');
            exit();
        }
    } else {
        // If validation fails, redirect to error page or handle the error
        header('Location: /pages/sidebarOptions/error.php');
        exit();
    }   
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recruitments</title>
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="/pages/register/register.css">
</head>
<body>
    <div class="container">
        <div class="image-side">
            <div class="overlay">
                <h1>Join Our Core Team</h1>
                <p>Be part of something extraordinary. Your journey starts here.</p>
            </div>
        </div>
        <div class="form-side">
            <form id="multi-step-form" action="/pages/register/register.php" method="POST">
                <div class="step-indicators">
                    <div class="step active" data-step="1">1</div>
                    <div class="step" data-step="2">2</div>
                    <div class="step" data-step="3">3</div>
                </div>

                <div class="step-content" data-step="1">
                    <h2>Personal Information</h2>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="id_number">ID Number</label>
                        <input type="text" id="id_number" name="id_number" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" required>
                    </div>
                </div>

                <div class="step-content" data-step="2" style="display: none;">
                    <h2>Role Information</h2>
                    <div class="form-group">
                        <label for="domain">Domain</label>
                        <select id="domain" name="domain" required>
                            <option value="">Select a domain</option>
                            <option value="Strategic Planning">Strategic Planning</option>
                            <option value="Public Relations and Additional Operations">Public Relations and Additional Operations</option>
                            <option value="Video Editor and Social Media Manager">Video Editor and Social Media Manager</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="role_expectations">What do you expect by gaining this role?</label>
                        <textarea id="role_expectations" name="role_expectations" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="club_expectations">What do you expect from the club in this role?</label>
                        <textarea id="club_expectations" name="club_expectations" rows="3" required></textarea>
                    </div>
                </div>

                <div class="step-content" data-step="3" style="display: none;">
                    <h2>Additional Information</h2>
                    <div class="form-group">
                        <label for="full_potential">Will you give your full potential for this role?</label>
                        <select id="full_potential" name="full_potential" required>
                            <option value="">Select an option</option>
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="previous_experience_link">Link for previous experience (if any)</label>
                        <input type="url" id="previous_experience_link" name="previous_experience_link">
                    </div>
                </div>

                <div class="form-navigation">
                    <button type="button" id="prev-btn" style="display: none;">Previous</button>
                    <button type="button" id="next-btn">Next</button>
                    <button type="submit" id="submit-btn" style="display: none;">Submit Application</button>
                </div>
            </form>
        </div>
    </div>
    <script src="/pages/register/register.js"></script>
</body>
</html>
