<?php
require 'db_config.php'; // Include the database configuration file

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Fetch counsellor name from the query parameter
if (!isset($_GET['counsellor'])) {
    die("No counsellor selected.");
}
$counsellor_name = htmlspecialchars($_GET['counsellor']);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $time = $_POST['time'];
    $google_meet_link = "https://meet.google.com/" . uniqid(); // Generate a unique Google Meet link

    // Insert the appointment into the database
    $sql = "INSERT INTO appointment (date, time_frame, meet_link) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error preparing statement: " . $conn->error);
    }

    if ($stmt) {
        $stmt->bind_param("sss", $date, $time, $google_meet_link);
        if ($stmt->execute()) {
            // Redirect to confirmation page with the Google Meet link
            header("Location: confirmation.php?link=" . urlencode($google_meet_link));
            exit();
        } else {
            $error = "Failed to book the appointment. Please try again.";
        }
    } else {
        $error = "Database error: Unable to prepare the statement.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make an Appointment</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        header {
            background-color: #801414;
            color: white;
            padding: 20px;
            text-align: center;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #801414;
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
            color: #444;
        }

        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #801414;
            color: white;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: #a82828;
        }

        .error {
            color: red;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <header>
        <h1>Book an Appointment with <?= $counsellor_name ?></h1>
    </header>
    <div class="container">
        <?php if (isset($error)): ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>
        <form action="appointment.php?counsellor=<?= urlencode($counsellor_name) ?>" method="POST">
            <label for="date">Select Date</label>
            <input type="date" id="date" name="date" min="<?= date('Y-m-d') ?>" required>

            <label for="time">Select Time</label>
            <select id="time" name="time" required>
                <?php
                // Generate time slots from 9:00 AM to 9:00 PM
                $start_time = strtotime('09:00');
                $end_time = strtotime('21:00');
                while ($start_time < $end_time) {
                    $slot = date('H:i:s', $start_time);
                    echo "<option value='$slot'>$slot</option>";
                    $start_time = strtotime('+1 hour', $start_time);
                }
                ?>
            </select>

            <button type="submit">Book Appointment</button>
        </form>
    </div>
</body>
</html>
<?php
$conn->close();
?>
