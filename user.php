<?php
session_start();

$errors=[
    'login'=> $_SESSION['login_error'] ?? '',
    'register'=> $_SESSION['register_error'] ?? ''
];
$activeForm= $_SESSION['active_form'] ?? 'login';
session_unset();
function showError($error){
return !empty($error) ? "<p class='error-message'>$error</p>" : "";
}
function isActiveForm($formName, $activeForm){
    return $formName=== $activeForm ? 'active' : '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<style>
    .formbox{
        display: none;
    }
    .formbox.active{
        display: block; 
    }
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

        .formbox {
            display: none;
        }

        .formbox.active {
            display: block;
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

        p {
            text-align: center;
            font-size: 0.9rem;
            color: rgba(255, 255, 255, 0.8);
        }

        a {
            color: #a3c7ff;
            text-decoration: none;
            font-weight: bold;
        }

        a:hover {
            text-decoration: underline;
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
<body>
    <div class="container">
        <div class="formbox <?= isActiveForm('login', $activeForm);?>" id="ulogin">
            <form action="login_register.php" method="post">
                <h2> LOGIN</h2>
                <?= showError($errors['login']);?>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="password" required>
                <button type="submit" name="login"> Login</button>
                <p> Don't have an account? <a href="#" onclick="showForm('ureg')"> Register </a></p>
            </form>
        </div>

        <div class="formbox" <?= isActiveForm('register', $activeForm);?> id="ureg">
            <form action="login_register.php" method="post">
                <h2> REGISTER</h2>
                <?= showError($errors['register']);?>
                <input type="name" name="name" placeholder="name">
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="password" required>
                <button type="submit" name="register"> Register</button>
                <p> Already have an account? <a href="#" onclick="showForm('ulogin')"> Login </a></p>
            </form>
        </div>

    </div>
    <script>
            function showForm(formId){
                document.querySelectorAll(".formbox").forEach(form => form.classList.remove("active"));
                document.getElementById(formId).classList.add("active");    
            }
    </script>
    
</body>
</html>