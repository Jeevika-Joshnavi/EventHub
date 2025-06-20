<?php
session_start();
require 'config.php';

if (!isset($_SESSION['email'])) {
    header('Location: admin.php');
    exit();
}

if (!isset($_GET['id'])) {
    echo "No event specified.";
    exit();
}

$id = intval($_GET['id']);

$stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: view-events.php?deleted=1");
exit();
?>
