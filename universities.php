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
    <style>
        /* General styling for the page */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/sukuna.jpg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
        }

        .universities-section {
            text-align: center;
            padding: 50px 20px;
            background: rgba(0, 0, 0, 0.7); /* Semi-transparent background  */
            border-radius: 10px;
            max-width: 1200px;
            margin: 50px auto;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .universities-section h1 {
            font-size: 2.5em;
            margin-bottom: 20px;
            color:rgb(255, 81, 0); /* Gold color for heading */
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        .universities-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            list-style: none;
            padding: 0;
            margin: 20px 0;
        }

        .universities-list li {
            background: rgba(237, 235, 235, 0.55); /* Transparent block */
            color: #fff;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            font-size: 1.2em;
            box-shadow: 0 4px 8px rgba(146, 146, 146, 0.2);
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .universities-list li:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.4);
        }

        .btn {
            display: inline-block;
            background-color: #FFD700;
            color: #000;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .btn:hover {
            background-color: #FFC107;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <section class="universities-section">
        <h1>Universities List</h1>
        <ul class="universities-list">
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
