<?php
include 'db.php';

// Sample values to insert
$users = [
    // [
    //     'id_number' => '2300032238',
    //     'name' => 'Yaswanth Kalluri',
    //     'password' => password_hash('yash', PASSWORD_DEFAULT),
    //     'mail' => '2300032238@Kluniversity.in',
    //     'role' => 'club_member'
    // ],
    [
        'id_number' => '2300032425',
        'name' => 'mahitha',
        'password' => password_hash('123', PASSWORD_DEFAULT),
        'mail' => '2300032425@kluniversity.in',
        'role' => 'club_core'
    ]
];

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, role) VALUES (?, ?, ?, ?, ?)");

foreach ($users as $user) {
    $stmt->bind_param("sssss", $user['id_number'], $user['name'], $user['password'], $user['mail'], $user['role']);
    
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
