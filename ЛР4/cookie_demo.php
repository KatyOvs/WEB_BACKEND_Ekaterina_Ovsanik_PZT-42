<?php
// Демонстрация работы с cookies

// Установка cookie при отправке формы
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['set_cookie'])) {
    $cookieValue = htmlspecialchars($_POST['cookie_value']);
    // Устанавливаем cookie на 30 дней
    setcookie('user_preference', $cookieValue, time() + 86400 * 30, '/', '', true, true);
    // Перезагружаем страницу, чтобы увидеть cookie
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit;
}

// Удаление cookie
if (isset($_GET['delete_cookie'])) {
    setcookie('user_preference', '', time() - 86400, '/');
    header('Location: ' . $_SERVER['SCRIPT_NAME']);
    exit;
}

// Чтение существующей cookie
$savedValue = $_COOKIE['user_preference'] ?? 'не установлена';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Демонстрация работы с Cookies</title>
    <meta charset="UTF-8">
</head>
<body>
    <h2>Работа с Cookie</h2>
    
    <p><strong>Текущее значение cookie 'user_preference':</strong> 
    <?= htmlspecialchars($savedValue) ?></p>
    
    <hr>
    
    <h3>Установить новое значение cookie:</h3>
    <form method="post">
        <input type="text" name="cookie_value" placeholder="Введите значение" required>
        <button type="submit" name="set_cookie">Установить cookie (на 30 дней)</button>
    </form>
    
    <br>
    <a href="?delete_cookie=1">Удалить cookie</a>
    <br><br>
    <a href="<?= $_SERVER['SCRIPT_NAME'] ?>">Обновить страницу</a>
    
    <hr>
    <h3>Информация о всех cookies:</h3>
    <pre><?php print_r($_COOKIE); ?></pre>
</body>
</html>