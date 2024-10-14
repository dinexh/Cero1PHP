<?php
require_once('db.php'); 
// Path to your CSV file
$csvFile = '/Users/dineshkorukonda/Developer/Cero1PHP/my-app/users.csv'; // Ensure this points to the actual CSV file
// Check if the CSV file exists
if (!file_exists($csvFile)) {
    echo "CSV file not found.";
    exit();
}

// Open the CSV file for reading
if (($handle = fopen($csvFile, 'r')) !== false) {
    // Skip the header row
    fgetcsv($handle);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO users (id_number, name, password, mail, role, cohort) VALUES (?, ?, ?, ?, ?, ?)");

    // Read each row of the CSV file
    while (($data = fgetcsv($handle, 1000, ',')) !== false) {
        // Ensure there are enough columns
        if (count($data) < 6) {
            echo "Row skipped due to insufficient data: " . implode(", ", $data) . "<br>";
            continue; // Skip to the next row if not enough data
        }

        // Assign data to variables
        $id_number = trim($data[0]);
        $name = trim($data[1]);
        $password = password_hash(trim($data[2]), PASSWORD_DEFAULT); // Hashing the password
        $mail = trim($data[3]);
        $role = trim($data[4]);
        $cohort = trim($data[5]);

        // Execute the statement with error handling
        if (!$stmt->execute([$id_number, $name, $password, $mail, $role, $cohort])) {
            echo "Error inserting user $name: " . $stmt->error . "<br>";
        }
    }

    fclose($handle);
    echo "Users inserted successfully.";

    // Close the statement
    $stmt->close();
} else {
    echo "Error opening the file. Check the file path.";
}

// Close the database connection
$conn->close();
?>
