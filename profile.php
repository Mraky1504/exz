<?php
session_start();
require_once 'db_config.php'; // Подключаем файл с параметрами подключения к базе данных

// Проверяем, авторизован ли пользователь
if (isset($_SESSION['userId'])) {
    // Подготавливаем SQL запрос для получения email текущего пользователя
    $sql = "SELECT email FROM users WHERE id = ?";
    
    // Подключаемся к базе данных
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    
    // Проверяем соединение
    if ($conn->connect_error) {
        die("Ошибка соединения: " . $conn->connect_error);
    }
    
    // Подготавливаем запрос
    $stmt = $conn->prepare($sql);
    
    // Привязываем параметр к ID текущего пользователя
    $stmt->bind_param("i", $_SESSION['userId']);
    
    // Выполняем запрос
    $stmt->execute();
    
    // Получаем результат запроса
    $result = $stmt->get_result();
    
    // Проверяем, есть ли результат
    if ($result->num_rows > 0) {
        // Получаем email пользователя из результата
        $row = $result->fetch_assoc();
        $email = $row['email'];
    } else {
        // Если не удалось получить email, устанавливаем его как пустую строку
        $email = '';
    }
    
    // Закрываем соединение и запрос
    $stmt->close();
    $conn->close();
} else {
    // Если пользователь не авторизован, перенаправляем его на страницу входа
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
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
        <h1>Автосалон</h1>
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
        <h2>Профиль пользователя</h2>
        <?php if (isset($_SESSION['userId'])): ?>
            <div style="text-align: center;">
                <div style="border: 2px solid #ccc; border-radius: 50%; width: 150px; height: 150px; margin: 0 auto;">
                    <!-- Вместо ссылки на изображение подставьте путь к фото пользователя -->
                    <img src="user.avif" alt="Фото пользователя" style="width: 100%; border-radius: 50%;">
                </div>
                <p style="margin-top: 10px; font-size: 18px;">Ваш логин: <?php echo $_SESSION['username']; ?></p>
                <p style="margin-top: 10px; font-size: 18px;">Ваш email: <?php echo $email; ?></p>
                <!-- Добавьте другие поля профиля, если необходимо -->
            </div>
        <?php else: ?>
            <p>Для просмотра профиля пожалуйста, <a href="login.php">войдите</a> или <a href="register.php">зарегистрируйтесь</a>.</p>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
