<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user_page.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register for Events</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #060b20 0%, #490e85 100%);
            color: white;
            min-height: 100vh;
            padding: 2rem;
            display: flex;
            justify-content: center;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        a {
            display: inline-block;
            margin-bottom: 1.5rem;
            color: #a3c7ff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
        }

        .event {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .event h3 {
            margin-bottom: 0.5rem;
            color: #fff;
        }

        .event p {
            color: rgba(255, 255, 255, 0.85);
            margin-bottom: 0.5rem;
        }

        .event form {
            margin-top: 1rem;
        }

        .event button {
            background-color: #4CAF50;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.3s ease;
        }

        .event button:hover {
            background-color: #45a049;
        }

        .registered {
            color: #9effa6;
            font-weight: bold;
        }

        p.message {
            text-align: center;
            margin-top: 2rem;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
        }

        @media (max-width: 600px) {
            .container {
                padding: 1.5rem;
            }
        }
        .event img {
    display: block;
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin: 1rem 0;
}

    </style>
</head>
<body>
    <div class="container">
    <h2>Available Events</h2>
    <a href="user_page.php">← Back to Dashboard</a>
    <hr>

    <?php
    $query = "SELECT * FROM events ORDER BY event_date";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        while ($event = $result->fetch_assoc()) {
            $event_id = $event['id'];

            // Check if user already registered
            $check = $conn->query("SELECT * FROM registrations WHERE user_id = $user_id AND event_id = $event_id");
            $already_registered = $check->num_rows > 0;

           echo "<div class='event'>";
echo "<h3>" . htmlspecialchars($event['title']) . "</h3>";

// Display image if present
if (!empty($event['image'])) {
    echo "<img src='uploads/" . htmlspecialchars($event['image']) . "' alt='Event Image' style='max-width: 100%; height: auto; margin: 10px 0; border-radius: 10px;'>";
}

echo "<p>" . htmlspecialchars($event['description']) . "</p>";

            echo "<p>Date: " . $event['event_date'] . "</p>";

            if ($already_registered) {
                echo "<p class='registered'>Already Registered</p>";
            } else {
                echo "<form method='POST' action='register_action.php'>";
                echo "<input type='hidden' name='event_id' value='{$event_id}'>";
                echo "<button type='submit'>Register</button>";
                echo "</form>";
            }

            echo "</div><hr>";
        }
    } else {
        echo "<p>No events available right now.</p>";
    }
    ?>
    </div>
</body>
</html>
