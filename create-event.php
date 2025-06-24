<?php
session_start();
require 'config.php';

if (!isset($_SESSION['email'])) {
    header('Location: admin.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $event_date = $_POST['event_date'];

    // Get admin ID
    $stmt = $conn->prepare("SELECT id FROM admins WHERE email = ?");
    $stmt->bind_param("s", $_SESSION['email']);
    $stmt->execute();
    $admin_result = $stmt->get_result();
    $admin = $admin_result->fetch_assoc();
    $admin_id = $admin['id'];

    // Image upload
    $image_name = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_name = basename($_FILES['image']['name']);
        $upload_dir = 'uploads/';

        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        move_uploaded_file($image_tmp, $upload_dir . $image_name);
    }

    // Insert event
    $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, created_by, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssis", $title, $description, $event_date, $admin_id, $image_name);

    if ($stmt->execute()) {
        header("Location: view-events.php?success=1");
        exit();
    } else {
        $error = "Failed to create event: " . $stmt->error;
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create Event</title>
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
         <a  href="admin_page.php" class="back">← Back to Dashboard</a>
    <h2>Create New Event</h2>
    <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    <form method="POST" action="" enctype="multipart/form-data">
        <input type="text" name="title" placeholder="Event Title" required><br><br>
        <textarea name="description" placeholder="Event Description" required></textarea><br><br>
        <input type="date" name="event_date" required><br><br>
        <!-- Image upload -->
        <input type="file" name="image" accept="image/*" required><br>

        <button type="submit">Create Event</button>
    </form>
    
    </div>
</body>
</html>
