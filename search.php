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

    //check for location or city
    if (!empty($location)) {
        $sql .= " AND (location LIKE ? OR city LIKE ?)";
        $params[] = "%$location%";
        $params[] = "%$location%";
    }

    //check for programs
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
        echo "Error preparing statement: " . $conn->error;
        exit;
    }
    //if (!empty($params)) {
       // $types = str_repeat('s', count($params));
       // $stmt->bind_param($types, ...$params);
    //}

    if (!empty($params)) {
        $types = str_repeat('s', count($params));
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();

    // Display results
    if ($result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
        while ($row = $result->fetch_assoc()) {
            echo "<p><strong>" . htmlspecialchars($row['name']) . "</strong></p>";
            echo "<p>Location: " . htmlspecialchars($row['location']) . "</p>";
            echo "<p>City: " . htmlspecialchars($row['city']) . "</p>";
            echo "<p>Program: " . htmlspecialchars($row['program']) . "</p>";
            echo "<a href='" . htmlspecialchars($row['official_website']) . "' target='_blank'>Visit Official Website</a><hr>";
        }
    } else {
        echo "<p>No universities found. Try refining your search criteria.</p>";
    }

    $stmt->close();
} else {
    echo "<p>Invalid request method. Please use the search form.</p>";
}

$conn->close();
?>


