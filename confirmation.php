<?php
if (!isset($_GET['link'])) {
    die("Invalid access.");
}
$google_meet_link = htmlspecialchars($_GET['link']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Confirmation</title>
    <link rel="stylesheet" href="styles.css">
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
            text-align: center;
        }

        h1 {
            color: #801414;
            margin-bottom: 20px;
        }

        a {
            display: inline-block;
            background-color: #801414;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }

        a:hover {
            background-color: #a82828;
        }
    </style>
</head>
<body>
    <header>
        <h1>Appointment Confirmed</h1>
    </header>
    <div class="container">
        <p>Your appointment has been successfully scheduled.</p>
        <p><strong>Google Meet Link:</strong></p>
        <a href="<?= $google_meet_link ?>" target="_blank"><?= $google_meet_link ?></a>
    </div>
</body>
</html>
