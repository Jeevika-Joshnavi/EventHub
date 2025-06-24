<?php
session_start();
require 'config.php';

if (!isset($_SESSION['reset_user_id'])) {
    header("Location: forgot-password.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['check_answer'])) {
    $answer = $_POST['secret_answer'];
    $user_id = $_SESSION['reset_user_id'];

    $stmt = $conn->prepare("SELECT secret_answer FROM users WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    $user = $res->fetch_assoc();

    if (password_verify($answer, $user['secret_answer'])) {
        $_SESSION['can_reset'] = true;
        header("Location: reset-password.php");
        exit();
    } else {
        $error = "Incorrect answer!";
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Answer Security Question</title>
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

        p {
            text-align: center;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.85);
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
    <h2>Answer Your Secret Question</h2>
    <p><strong><?= htmlspecialchars($_SESSION['reset_question']) ?></strong></p>
    <?php if (isset($error)) echo "<p class='error-message'>$error</p>"; ?>
    <form method="POST">
        <input type="text" name="secret_answer" placeholder="Your Answer" required>
        <button type="submit" name="check_answer">Submit</button>
    </form>
    </div>
</body>
</html>
