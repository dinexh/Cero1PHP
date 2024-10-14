<?php
include 'db.php';

$users = [
    [
        'id_number' => '2300030350',
        'name' => 'Dinesh Korukonda',
        'password' => password_hash('123', PASSWORD_DEFAULT),
        'mail' => '2300030350@kluniversity.in',
        'role' => 'DSIOG',
        'cohort' => 'phantom'
    ],
    [
        'id_number' => '2300033327',
        'name' => 'N Sai Rekha',
        'password' => password_hash('123', PASSWORD_DEFAULT),
        'mail' => '2300033327@kluniversity.in',
        'role' => 'DSIOG',
        'cohort' => 'phantom'
    ]
];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, role, cohort) VALUES (?, ?, ?, ?, ?, ?)");

foreach ($users as $user) {
    // Update the bind_param to "ssssss" for 6 values
    $stmt->bind_param("ssssss", $user['id_number'], $user['name'], $user['password'], $user['mail'], $user['role'], $user['cohort']);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully for " . $user['name'] . "<br>";
    } else {
        echo "Error: " . $stmt->error . "<br>";
    }
}

// Close the statement and connection
$stmt->close();
$conn->close();
?>