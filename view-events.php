<?php
session_start();
require 'config.php';

if (!isset($_SESSION['email'])) {
    header('Location: admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Events</title>
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

        .success-message {
            background: rgba(0, 255, 0, 0.1);
            color: #9effa6;
            padding: 0.75rem;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 1rem;
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

        .event-actions a {
            color: #a3c7ff;
            text-decoration: none;
            margin-right: 1rem;
            font-weight: bold;
        }

        .event-actions a:hover {
            text-decoration: underline;
        }

        hr {
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            margin: 1.5rem 0;
        }

        @media (max-width: 600px) {
            .container {
                padding: 1.5rem;
            }

            .event-actions a {
                display: block;
                margin-bottom: 0.5rem;
            }
        }
        .back {
    display: inline-block;
    margin-bottom: 1rem;
    color: #ffffff;
    text-decoration: none;
    font-weight: bold;
    font-size: 1rem;
    transition: color 0.3s ease;
}

.back:hover {
    color: #ddd;
}
img {
    display: block;
    max-width: 100%;
    height: auto;
    border-radius: 10px;
    margin-bottom: 1rem;
}


    </style>
</head>
<body>
    <div class="container">
        <a href="admin_page.php" class="back">← Back to Dashboard</a>
    <h2>All Events</h2>
    <?php if (isset($_GET['success'])) echo "<p style='color:green;'>Event created successfully!</p>"; ?>

    <?php
    $result = $conn->query("SELECT * FROM events ORDER BY event_date");

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
           echo "<div class='event'>";

echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";

// Check if image exists
if (!empty($row['image'])) {
    echo "<img src='uploads/" . htmlspecialchars($row['image']) . "' alt='Event Image' style='max-width: 100%; height: auto; margin: 10px 0; border-radius: 10px;'>";
}

echo "<p>" . htmlspecialchars($row['description']) . "</p>";

            echo "<p>Date: " . $row['event_date'] . "</p>";
            echo "<a href='edit_event.php?id=" . $row['id'] . "'>Edit</a> | ";
            echo "<a href='delete_event.php?id=" . $row['id'] . "' onclick=\"return confirm('Are you sure?');\">Delete</a> | ";
            echo "<a href='view_registrations.php?id=" . $row['id'] . "'>Registrations</a>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>No events found.</p>";
    }
    ?>
    
    </div>
</body>
</html>
