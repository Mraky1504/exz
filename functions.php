<?php
// Подключаем файл с параметрами подключения к базе данных
require_once 'db_config.php';

// Функция для подключения к базе данных
function connectDB() {
    global $db_servername, $db_username, $db_password, $db_name;
    $conn = new mysqli($db_servername, $db_username, $db_password, $db_name);
    return $conn;
}

// Функция для регистрации пользователя
function registerUser($user_username, $user_password, $user_email) {
    $conn = connectDB();
    $hashedPassword = password_hash($user_password, PASSWORD_DEFAULT);
    $sql = "INSERT INTO users (username, password, email) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $user_username, $hashedPassword, $user_email);
    $result = $stmt->execute();
    $stmt->close();
    $conn->close();
    return $result;
}

// Функция для авторизации пользователя и получения email
// Функция для авторизации пользователя и получения email
function loginUser($username, $password) {
    $conn = connectDB();
    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $stmt->close();
            $conn->close();
            return $user;
        }
    }
    $stmt->close();
    $conn->close();
    return false;
}



// Функция для проверки роли пользователя
function checkUserRole($userId) {
    $conn = connectDB();
    $sql = "SELECT role FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows == 1) {
        $role = $result->fetch_assoc()['role'];
        $stmt->close();
        $conn->close();
        return $role;
    }
    $stmt->close();
    $conn->close();
    return false;
}
?>
