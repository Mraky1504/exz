<?php
session_start();
session_unset();
session_destroy();
header("location: index.php"); // Перенаправляем пользователя на главную страницу после выхода из системы
?>
