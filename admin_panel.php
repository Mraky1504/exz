<?php
session_start();
if (!isset($_SESSION['userId']) || $_SESSION['userRole'] !== 'admin') {
    header("Location: login.php");
    exit();
}

require_once 'db_config.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Админ паенль</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #2b1b1b;
            padding: 20px 0;
            color: white;
            text-align: center;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        nav {
            margin-top: 20px;
            text-align: center;
        }
        nav a {
            color: white;
            text-decoration: none;
            margin: 0 10px;
        }
        nav a:hover {
            text-decoration: underline;
        }
        .content {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<header>
    <div class="container">
        <h1>Администрирование</h1>
        <nav>
            <?php if (!isset($_SESSION['userId'])): ?>
                <a href="index.php">Главная</a>
                <a href="about.php">О нас</a>
                <a href="contacts.php">Контакты</a>
                <a href="login.php">Вход</a>
                <a href="register.php">Регистрация</a>
            <?php elseif ($_SESSION['userRole'] === 'admin'): ?>
                <a href="index.php">Главная</a>
                <a href="admin_panel.php">Админ панель</a>
                <a href="logout.php">Выход</a>
            <?php else: ?>
                <a href="index.php">Главная</a>
                <a href="about.php">О нас</a>
                <a href="contacts.php">Контакты</a>
                <a href="orders.php">Заказы</a>
                <a href="profile.php">Профиль</a>
                <a href="logout.php">Выход</a>
            <?php endif; ?>
        </nav>
    </div>
</header>

<div class="content">
    <div class="container">
        <h2>Админ Панель - Пользователи</h2>

        <?php
        // Получение всех пользователей из базы данных
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);

        // Вывод каждого пользователя в красивой рамочке
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div style="border: 1px solid #ccc; border-radius: 10px; padding: 10px; margin-bottom: 20px;">';
                echo '<h3>' . $row['username'] . '</h3>';
                echo '<p>Email: ' . $row['email'] . '</p>';
                echo '<p>Роль: ' . $row['role'] . '</p>';
                echo '<p>Хэш пароля: ' . $row['password'] . '</p>';
                // Добавьте другие данные пользователя по вашему усмотрению
                echo '</div>';
            }
        } else {
            echo "Пользователи не найдены.";
        }
        ?>
    </div>
</div>

</body>
</html>
