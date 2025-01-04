<?php
$host = 'localhost'; // Host for your database (default: localhost)
$user = 'root';      // Your MySQL username (default: root for XAMPP)
$password = '';      // Your MySQL password (default: empty for XAMPP)
$database = 'university_portal'; // Replace with your database name

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
