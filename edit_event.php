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

$id = intval($_GET['id']);

// Fetch event details
$stmt = $conn->prepare("SELECT * FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$event = $result->fetch_assoc();

if (!$event) {
    echo "Event not found.";
    exit();
}

// Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    $stmt = $conn->prepare("UPDATE events SET title = ?, description = ?, event_date = ? WHERE id = ?");
    $stmt->bind_param("sssi", $title, $description, $event_date, $id);

    if ($stmt->execute()) {
        header("Location: view-events.php?updated=1");
        exit();
    } else {
        $error = "Update failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Event</title>

    <style> 
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #060b20 0%, #490e85 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            color: white;
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        input, textarea {
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1rem;
        }

        input::placeholder,
        textarea::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.3);
            color: white;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        .error-message {
            background: rgba(255, 0, 0, 0.2);
            color: #ff8a8a;
            padding: 0.5rem;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 1rem;
        }

        @media (max-width: 500px) {
            .container {
                padding: 1.5rem;
                max-width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
    <h2>Edit Event</h2>
    <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="title" value="<?= htmlspecialchars($event['title']) ?>" required><br><br>
        <textarea name="description" required><?= htmlspecialchars($event['description']) ?></textarea><br><br>
        <input type="date" name="event_date" value="<?= $event['event_date'] ?>" required><br><br>
        <button type="submit">Update Event</button>
    </form>
    <a href="admin_page.php">← Back to Dashboard</a>
    </div>
</body>
</html>
