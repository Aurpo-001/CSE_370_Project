<?php
require 'db_config.php'; // Include the database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $location = $_POST['location'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Check if all fields are provided
    if (empty($name) || empty($email) || empty($location) || empty($password) || empty($phone)) {
        die("All fields are required. Please go back and fill in all the fields.");
    }

    // Prepare and execute SQL query
    $sql = "INSERT INTO users (name, email, location, password, phone) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param("sssss", $name, $email, $location, $password, $phone);

    if ($stmt->execute()) {
        echo "Signup successful! Your User ID is: " . $stmt->insert_id;
    } else {
        echo "Error inserting data: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request method.";
}
