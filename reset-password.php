<?php
session_start();
require 'config.php';

if (!isset($_SESSION['can_reset']) || !$_SESSION['can_reset']) {
    header("Location: forgot-password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reset'])) {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $user_id = $_SESSION['reset_user_id'];

    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_password, $user_id);

    if ($stmt->execute()) {
        // Clear session variables
        session_unset();
        session_destroy();
        header("Location: user.php?reset=1");
        exit();
    } else {
        $error = "Failed to reset password.";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Reset Password</title>
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
            max-width: 400px;
            color: white;
        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: white;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        input {
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1rem;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        button {
            padding: 0.75rem;
            background: rgba(255, 255, 255, 0.3);
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
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
            font-size: 0.9rem;
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
    <h2>Reset Your Password</h2>
    <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    <form method="POST">
        <input type="password" name="new_password" placeholder="New Password" required>
        <button type="submit" name="reset">Reset Password</button>
    </form>
</div>
</body>
</html>
