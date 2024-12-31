<?php
require 'db_config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Check if the email and password are correct
    $sql = "SELECT id, name FROM users WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.html"); // Redirect to the main page
        exit;
    } else {
        echo "Invalid email or password.";
    }

    $stmt->close();
    $conn->close();
}
?>
