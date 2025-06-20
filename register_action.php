<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: user.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $event_id = intval($_POST['event_id']);

    // Check if already registered
    $check = $conn->query("SELECT id FROM registrations WHERE user_id = $user_id AND event_id = $event_id");

    if ($check->num_rows == 0) {
        $stmt = $conn->prepare("INSERT INTO registrations (user_id, event_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $user_id, $event_id);
        $stmt->execute();
    }

    header("Location: register-event.php");
    exit();
}
?>
