<?php
require 'db_config.php'; // Include database configuration

// Fetch counsellors specializing in Visa Guidance
$sql = "SELECT name, email, phone FROM counsellor WHERE specialization = 'Visa Guidance' ";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visa Guidance Counselors</title>
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
            text-align: center;
            margin-bottom: 20px;
        }

        .counsellor-card {
            background-color: #e8f5e9;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .counsellor-card h2 {
            margin: 0;
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
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .no-results {
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <header>
        <h1>Visa Guidance Counselors</h1>
    </header>
    <div class="container">
        <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="counsellor-card">
                    <h2><?= htmlspecialchars($row['name']) ?></h2>
                    <p>Email: <?= htmlspecialchars($row['email']) ?></p>
                    <p>Phone: <?= htmlspecialchars($row['phone']) ?></p>
                    <a href="appointment.php?counsellor=<?= urlencode($row['name']) ?>" class="btn">Make an Appointment</a>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="no-results">No counselors available for Visa Guidance at the moment.</p>
        <?php endif; ?>
        <a href="visa_guidance.html" class="btn">Back</a>
    </div>
</body>
</html>
<?php
$conn->close();
?>
