<?php
session_start();
require_once 'config.php';

if (isset($_POST['register'])) {
    $name  = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $secret_question = $_POST['secret_question'];
    $secret_answer = password_hash($_POST['secret_answer'], PASSWORD_DEFAULT); // Hashing answer

    // Check if email already exists
    $checkEmail = $conn->query("SELECT email FROM users WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        $_SESSION['register_error'] = 'Email is already registered!';
        $_SESSION['active_form'] = 'register';
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (email, name, password, secret_question, secret_answer) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $email, $name, $password, $secret_question, $secret_answer);
        $stmt->execute();
    }

    header("Location: user.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE email = '$email'");
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name']    = $user['name'];
            $_SESSION['email']   = $user['email'];
            header("Location: user_page.php");
            exit();
        }
    }

    $_SESSION['login_error'] = 'Incorrect email or password';
    $_SESSION['active_form'] = 'login';
    header("Location: user.php");
    exit();
}
?>
