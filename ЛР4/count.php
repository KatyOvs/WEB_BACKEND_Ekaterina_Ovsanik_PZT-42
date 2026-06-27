<?php
session_start();

// Инициализация счётчика
if (!isset($_SESSION['page_views'])) {
    $_SESSION['page_views'] = 0;
}

$_SESSION['page_views']++;

// Демонстрация идентификатора сессии
$sessionName = session_name();
$sessionId = session_id();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Счётчик просмотров (сессии)</title>
    <meta charset="UTF-8">
</head>
<body>
    <h3>Вы открыли эту страницу <?= $_SESSION['page_views'] ?> раз(а)</h3>
    <p><strong>Имя сессии:</strong> <?= htmlspecialchars($sessionName) ?></p>
    <p><strong>Идентификатор сессии:</strong> <?= htmlspecialchars($sessionId) ?></p>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>">Обновить страницу</a>
    <hr>
    <p><small>Сессия будет активна, пока открыт браузер</small></p>
</body>
</html>