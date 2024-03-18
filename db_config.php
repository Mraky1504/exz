<?php
$db_servername = "localhost";
$db_username = "root";
$db_password = "";
$db_name = "exz";

$conn = new mysqli($db_servername, $db_username, $db_password, $db_name);

// Проверяем соединение
if ($conn->connect_error) {
    die("Ошибка соединения: " . $conn->connect_error);
}
?>
