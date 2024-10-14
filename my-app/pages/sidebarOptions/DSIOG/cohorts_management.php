<?php
session_start();
require_once(__DIR__ . '/../../../db.php'); // Correct the path
require_once(__DIR__ . '/../../../config.php');

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit();
}

$pageTitle = 'Cohorts Management';
$studentData = []; 

// Handle cohort filtering
$selectedCohort = '';
if (isset($_GET['cohort'])) {
    $selectedCohort = $_GET['cohort'];

    if ($selectedCohort === '') {
        // Fetch all students
        $sql = "SELECT * FROM users";
    } else {
        // Fetch students by cohort
        $sql = "SELECT * FROM users WHERE cohort = ?";
    }
    $stmt = $conn->prepare($sql);
    if ($selectedCohort !== '') {
        $stmt->bind_param("s", $selectedCohort);
    }
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $studentData[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="cohorts-m-container">
        <div class="cohorts-m-container-in">
            <div class="cohorts-m-heading">
                <h1>Manage Cohorts of ZeroOne Code Club</h1>
            </div>
        </div>

        <!-- Filter Buttons for Cohorts -->
        <div class="cohort-s-subheading">
            <form method="get" action="">
                <button type="submit" name="cohort" value="">All Cohorts</button>
                <button type="submit" name="cohort" value="Phantom">Phantom</button>
                <button type="submit" name="cohort" value="Falcon">Falcon</button>
                <button type="submit" name="cohort" value="Registered">Registered</button>
                <button type="submit" name="cohort" value="Nebula">Nebula</button>
                <button type="submit" name="cohort" value="TNTC">TNTC</button>
            </form>
        </div>

        <!-- Student List Table -->
        <div class="cohort-m-table">
            <?php if (!empty($studentData)): ?>
                <div class="student-list">
                    <h2>Student List</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>ID Number</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Cohort Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($studentData as $student): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($student['id_number']); ?></td>
                                    <td><?php echo htmlspecialchars($student['name']); ?></td>
                                    <td><?php echo htmlspecialchars($student['mail']); ?></td>
                                    <td><?php echo htmlspecialchars($student['cohort']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p>No students found for the selected cohort.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
