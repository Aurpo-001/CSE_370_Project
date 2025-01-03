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
        die("<div class='message error'>All fields are required. Please go back and fill in all the fields.</div>");
    }

    // Prepare and execute SQL query
    $sql = "INSERT INTO users (name, email, location, password, phone) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("<div class='message error'>Error preparing the statement: " . $conn->error . "</div>");
    }

    $stmt->bind_param("sssss", $name, $email, $location, $password, $phone);

    if ($stmt->execute()) {
        echo "<div class='message success'>Signup successful! Your User ID is: " . $stmt->insert_id . "</div>";
        echo "<a href='index.html' class='home-btn'>Go to Home</a>";
    } else {
        echo "<div class='message error'>Error inserting data: " . $stmt->error . "</div>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<div class='message error'>Invalid request method.</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #1d1c1c;
            color: #fff;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            text-align: center;
            max-width: 500px;
            padding: 20px;
            background-color: #2a2a2a;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .message {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 5px;
            font-size: 18px;
            text-align: center;
        }

        .message.success {
            background-color: #7c2f2f;
            color: #fff;
        }

        .message.error {
            background-color: #bf4040;
            color: #fff;
        }

        .home-btn {
            display: inline-block;
            background-color: #7c2f2f;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            font-size: 16px;
        }

        .home-btn:hover {
            background-color: #bf4040;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- The PHP script dynamically inserts the signup status and "Go to Home" button here -->
    </div>
</body>
</html>
