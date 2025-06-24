<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_email'])) {
    $email = $_POST['email'];

    $stmt = $conn->prepare("SELECT id, secret_question FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $user = $res->fetch_assoc();
        $_SESSION['reset_user_id'] = $user['id'];
        $_SESSION['reset_email'] = $email;
        $_SESSION['reset_question'] = $user['secret_question'];
        header("Location: answer-question.php");
        exit();
    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Forgot Password</title>
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

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        h2 {
            text-align: center;
            margin-bottom: 1rem;
            color: white;
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
    <h2>Forgot Password</h2>
    <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    <form method="POST">
        <input type="email" name="email" placeholder="Enter your registered email" required>
        <button type="submit" name="check_email">Next</button>
    </form>
    </div>
</body>
</html>
