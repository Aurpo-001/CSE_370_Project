<?php
require 'db_config.php'; // Include database configuration

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Get search parameters
    $location = isset($_GET['location']) ? trim($_GET['location']) : '';
    $program = isset($_GET['program']) ? trim($_GET['program']) : '';
    $name = isset($_GET['name']) ? trim($_GET['name']) : '';

    // Build the SQL query
    $sql = "SELECT * FROM universities WHERE 1=1";
    $params = [];

    // Check for location or city
    if (!empty($location)) {
        $sql .= " AND (location LIKE ? OR city LIKE ?)";
        $params[] = "%$location%";
        $params[] = "%$location%";
    }

    // Check for programs
    if (!empty($program)) {
        $sql .= " AND program LIKE ?";
        $params[] = "%$program%";
    }

    // Check for university name
    if (!empty($name)) {
        $sql .= " AND name LIKE ?";
        $params[] = "%$name%";
    }

    // Prepare and execute the query
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        echo "<div class='error'>Error preparing statement: " . $conn->error . "</div>";
        exit;
    }

    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
}

// Function to get random degrees for each university
function getRandomDegrees($conn) {
    $degree_sql = "SELECT name FROM degree ORDER BY RAND() LIMIT 2"; // Fetch 2 random degrees
    $degree_stmt = $conn->prepare($degree_sql);
    if (!$degree_stmt) {
        return ["Error fetching degrees"];
    }
    $degree_stmt->execute();
    $degree_result = $degree_stmt->get_result();
    $degrees = [];
    while ($degree_row = $degree_result->fetch_assoc()) {
        $degrees[] = $degree_row['name'];
    }
    $degree_stmt->close();
    return $degrees;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/bg.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        header {
            background-color: rgba(128, 20, 20, 0.9);
            padding: 20px;
            text-align: center;
            color: #fff;
            font-size: 24px;
            text-shadow: 1px 1px 2px #000;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .university-box {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid #801414;
            padding: 15px;
            margin: 10px 0;
            border-radius: 8px;
            text-align: left;
        }

        .university-box h3 {
            margin: 0 0 10px;
            color: #ffdddd;
        }

        .university-box p {
            margin: 5px 0;
        }

        .university-box a {
            display: inline-block;
            margin-top: 10px;
            padding: 8px 15px;
            background-color: #801414;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .university-box a:hover {
            background-color: #a62828;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #801414;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            text-align: center;
        }

        .back-button:hover {
            background-color: #a62828;
        }

        .no-results {
            text-align: center;
            font-size: 18px;
            margin: 20px 0;
        }
    </style>
</head>
<body>

<header>
    Search Results
</header>

<div class="container">
    <?php if (isset($result) && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="university-box">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($row['location']); ?></p>
                <p><strong>City:</strong> <?php echo htmlspecialchars($row['city']); ?></p>
                <p><strong>Program:</strong>
                    <button onclick="window.location.href='program.php?program=<?php echo urlencode($row['program']); ?>'">
                        <?php echo htmlspecialchars($row['program']); ?>
                    </button>
                </p>
                <p><strong>Degree:</strong> 
                    <?php 
                        $degrees = getRandomDegrees($conn);
                        echo implode(', ', $degrees); 
                    ?>
                </p>
                <a href="<?php echo htmlspecialchars($row['official_website']); ?>" target="_blank">Visit Official Website</a>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-results">No universities found. Try refining your search criteria.</div>
    <?php endif; ?>

    <a href="index.html" class="back-button">Back to Home</a>
</div>

<?php
if (isset($stmt)) {
    $stmt->close();
}
$conn->close();
?>

</body>
</html>
