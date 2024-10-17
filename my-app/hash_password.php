<?php
$hashedPassword = '$2y$10$2ROB2hqtk2FKZyWYukheku1zY1pTZMlaRftDh4NlKiHLtrzx0V3me'; // Replace this with the actual hashed password from the DB
$inputPassword = '123';

if (password_verify($inputPassword, $hashedPassword)) {
    echo "Password matches!";
} else {
    echo "Password does not match!";
}
?>