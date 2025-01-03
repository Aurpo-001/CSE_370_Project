<?php
require 'db_config.php'; // Include database configuration

// Fetch counsellors specializing in Visa Guidance
$sql = "SELECT name, email, phone FROM counsellor WHERE specialization = 'Accommodation Services'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Application Assistance</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }

        header {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .counsellor-card {
            text-align: left;
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .counsellor-card h2 {
            margin: 0 0 10px;
            color: #4CAF50;
        }

        .counsellor-card p {
            margin: 5px 0;
            color: #555;
        }

        .btn {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            text-align: center;
        }

        .btn:hover {
            background-color: #45a049;
        }

        footer {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #333;
            color: white;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <h1>University Application Assistance</h1>
    </header>
    <div class="container">
        <?php
        if ($result->num_rows > 0) {
            echo "<h2>Our Counselors:</h2>";
            while ($row = $result->fetch_assoc()) {
                echo "<div class='counsellor-card'>";
                echo "<h2>" . htmlspecialchars($row['name']) . "</h2>";
                echo "<p>Email: " . htmlspecialchars($row['email']) . "</p>";
                echo "<p>Phone: " . htmlspecialchars($row['phone']) . "</p>";
                echo "<a href='appointment.php?counsellor=" . urlencode($row['name']) . "' class='btn'>Make an Appointment</a>";
                echo "</div>";
            }
        } else {
            echo "<p>No counsellors available for University Application Assistance at the moment.</p>";
        }
        ?>
        <a href="university_application.html" class="btn">Back</a>
    </div>
    <footer>
        <p>&copy; 2024 Sukuna Was The Strongest. All rights reserved.</p>
    </footer>
</body>
</html>
<?php
$conn->close();
?>
