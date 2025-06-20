<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user.php");
    exit();
}

$user_id = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Registered Events</title>
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
    </style>
</head>
<body>
    <div class="container">
    <h2>Your Registered Events</h2>
    <a href="user_page.php">← Back to Dashboard</a>
    <hr>

    <?php
    $sql = "SELECT e.title, e.description, e.event_date
            FROM events e
            JOIN registrations r ON e.id = r.event_id
            WHERE r.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        while ($event = $res->fetch_assoc()) {
            echo "<div style='margin-bottom:20px'>";
            echo "<h3>" . htmlspecialchars($event['title']) . "</h3>";
            echo "<p>" . htmlspecialchars($event['description']) . "</p>";
            echo "<p>Date: " . $event['event_date'] . "</p>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>You have not registered for any events yet.</p>";
    }
    ?>
    </div>  
</body>
</html>
