<?php
include 'db.php';

// Check if the database connection is successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$users = [
    [
        'id_number' => '230030350',
        'name' => 'Dinesh Korukonda',
        'password' => password_hash('123', PASSWORD_DEFAULT),
        'mail' => '230030350@kluniversity.in',
        'role' => 'DSIOG',
        'cohort' => 'TNTC',
        'message_code' => 'ZeroOne'
    ],
    [
        'id_number' => '230031401',
        'name' => 'K Nithin Kumar',
        'password' => password_hash('123', PASSWORD_DEFAULT),
        'mail' => '230031401@kluniversity.in',
        'role' => 'club_member',
        'cohort' => 'phantom',
        'message_code' => 'swara'
    ]
];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, role, cohort, message_code) VALUES (?, ?, ?, ?, ?, ?, ?)");

// Check if the statement was prepared successfully
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}

// Loop through each user and execute the insert statement
foreach ($users as $user) {
    // Update the bind_param to "sssssss" for 7 values
    $stmt->bind_param("sssssss", 
        $user['id_number'], 
        $user['name'], 
        $user['password'], 
        $user['mail'], 
        $user['role'], 
        $user['cohort'], 
        $user['message_code'] // Added quotes around the array key
    );
    
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
