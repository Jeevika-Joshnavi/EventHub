<?php
session_start();
require 'config.php';

if (!isset($_SESSION['email'])) {
    header('Location: admin.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "No event selected.";
    exit();
}

$event_id = intval($_GET['id']);

// Fetch event title
$event = $conn->query("SELECT title FROM events WHERE id = $event_id")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrations for <?= htmlspecialchars($event['title']) ?></title>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 700px;
        }

        h2 {
            margin-bottom: 1rem;
            text-align: center;
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

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            background: rgba(255, 255, 255, 0.15);
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 10px;
        }

        li strong {
            color: #ffffff;
        }

        p {
            text-align: center;
            margin-top: 2rem;
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.7);
        }

        @media (max-width: 600px) {
            .container {
                padding: 1.5rem;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Registrations for <?= htmlspecialchars($event['title']) ?></h2>
    <a href="view-events.php">← Back to Events</a><br><br>

    <?php
    $sql = "SELECT users.name, users.email, registrations.registered_at 
            FROM registrations
            JOIN users ON registrations.user_id = users.id
            WHERE registrations.event_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li><strong>{$row['name']}</strong> ({$row['email']}) - Registered at {$row['registered_at']}</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>No registrations yet.</p>";
    }
    ?>
    
    </div>  
</body>
</html>
