<?php
require 'db_config.php'; // Include database configuration

if (isset($_GET['program'])) {
    // Get the program name from the URL and sanitize it
    $programName = trim($_GET['program']);
    $programName = $conn->real_escape_string($programName);

    // Prepare the SQL query to fetch program details
    $sql = "SELECT * FROM programs WHERE name = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        echo "Error preparing statement: " . $conn->error;
        exit;
    }

    $stmt->bind_param('s', $programName);
    $stmt->execute();
    $result = $stmt->get_result();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Program Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/background.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(128, 0, 0, 0.9);
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        h2 {
            margin-bottom: 20px;
            color: #ffcccc;
        }

        .program-details {
            text-align: left;
            margin-bottom: 20px;
        }

        .program-details p {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
        }

        img {
            width: 300px;
            height: 200px;
            margin-top: 10px;
            border-radius: 10px;
            border: 2px solid #ffcccc;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #b30000;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color: #ff3333;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php
        if (isset($result) && $result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "<h2>Program Details</h2>";
            echo "<div class='program-details'>";
            echo "<p><strong>ID:</strong> " . htmlspecialchars($row['id']) . "</p>";
            echo "<p><strong>Name:</strong> " . htmlspecialchars($row['name']) . "</p>";
            echo "<p><strong>Duration:</strong> " . htmlspecialchars($row['duration']) . "</p>";
            echo "<p><strong>Fees:</strong> $" . htmlspecialchars($row['fees']) . "</p>";
            echo "<p><strong>Pre-requisites:</strong> " . htmlspecialchars($row['pre_requisites']) . "</p>";
            echo "</div>";

            // Display an image based on the program name
            $images = [
                'Computer Science' => 'images/computer_science.jpg',
                'Physics' => 'images/physics.jpg',
                'Mathematics' => 'images/mathmatics.jpg',
                'Business Management' => 'images/business_administration.jpg',
                'Data Science' => 'images/data_science.jpg',
                'Artificial Intelligence' => 'images/ai.jpeg',
                'Criminology' => 'images/law.jpg',
            ];

            if (array_key_exists($row['name'], $images)) {
                echo "<img src='" . htmlspecialchars($images[$row['name']]) . "' alt='" . htmlspecialchars($row['name']) . "'>";
            } else {
                echo "<p>No image available for this program.</p>";
            }

        } else {
            echo "<p>Program not found. Please try again.</p>";
        }

        // Back to search page button
        echo "<a href='search.php'>Back to Search</a>";
        ?>
    </div>
</body>
</html>

<?php
$conn->close();
?>
