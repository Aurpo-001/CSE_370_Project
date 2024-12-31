<?php
include 'db_config.php'; // Database configuration

// Fetch all universities from the table
$sql = "SELECT id, name FROM universities ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universities List</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <section class="universities-section">
        <h1>Universities List</h1>
        <ul>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<li>" . htmlspecialchars($row['name']) . "</li>";
                }
            } else {
                echo "<p>No universities found.</p>";
            }
            ?>
        </ul>
        <a href="index.html" class="btn">Back to Home</a>
    </section>
</body>
</html>
<?php
$conn->close();
?>
