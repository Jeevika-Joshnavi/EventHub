<?php
session_start();
require_once 'config.php';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $user = $result->fetch_assoc();
        if($password === $user['password']){
            $_SESSION['email'] = $user['email'];
            header("Location: admin_page.php");
            exit();
        }
    }
    $_SESSION['login_error']='Incorrect email or password';
    $_SESSION['active_form']='login';
    header("Location: admin.php");
    exit();
 }

 ?>
