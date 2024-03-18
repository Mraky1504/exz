<?php
session_start();
require_once 'functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    
    if (registerUser($username, $password, $email)) {
        $_SESSION['message'] = "Регистрация прошла успешно!";
        header("location: login.php");
    } else {
        $_SESSION['message'] = "Ошибка регистрации пользователя.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #2b1b1b;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        input[type="text"],
        input[type="password"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            background-color: #3f51b5;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2c387e;
        }
        .error-message {
            color: red;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Автосалон</h1>
        <p>Лучшее место для регистрации</p>
    </div>
    <div class="container">
        <h2>Регистрация</h2>
        <?php
        if (isset($_SESSION['message'])) {
            echo "<p class='error-message'>{$_SESSION['message']}</p>";
            unset($_SESSION['message']);
        }
        ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" name="registerForm" onsubmit="return validateRegisterForm()">
            <label>Имя пользователя:</label><br>
            <input type="text" name="username" required><br>
            <label>Email:</label><br>
            <input type="email" name="email" required><br>
            <label>Пароль:</label><br>
            <input type="password" name="password" required><br><br>
            <input type="submit" value="Зарегистрироваться">
        </form>
    </div>
</body>
<script>
    function validateRegisterForm() {
        var username = document.forms["registerForm"]["username"].value;
        var email = document.forms["registerForm"]["email"].value;
        var password = document.forms["registerForm"]["password"].value;
        
        if (username == "" || email == "" || password == "") {
            alert("Пожалуйста, заполните все поля.");
            return false;
        }
        if (!isValidEmail(email)) {
            alert("Пожалуйста, введите корректный email.");
            return false;
        }
        return true;
    }

    function isValidEmail(email) {
        var emailRegex = /\S+@\S+\.\S+/;
        return emailRegex.test(email);
    }
</script>

</html>
