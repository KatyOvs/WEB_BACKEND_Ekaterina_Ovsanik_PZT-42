<?php
/**
 * Задание 2: Обработка формы авторизации (POST-запрос)
 * Получает данные из login_form.php
 */

// Проверяем, была ли отправлена форма
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Проверяем наличие полей
    if (isset($_POST['username']) && isset($_POST['userpass'])) {
        // Получаем данные и защищаем от XSS с помощью htmlentities()
        $username = htmlentities($_POST['username'], ENT_QUOTES, 'UTF-8');
        $password = $_POST['userpass']; // Пароль не выводим, только проверяем
        
        // Выводим приветствие
        echo "<!DOCTYPE html>
        <html lang='ru'>
        <head>
            <meta charset='UTF-8'>
            <title>Авторизация</title>
            <style>
                body { font-family: Arial, sans-serif; max-width: 400px; margin: 50px auto; padding: 20px; }
                .success { background-color: #d4edda; color: #155724; padding: 15px; border-radius: 4px; }
                a { color: #2f5377; text-decoration: none; }
                a:hover { text-decoration: underline; }
            </style>
        </head>
        <body>
            <div class='success'>
                <h2>Добро пожаловать, $username!</h2>
                <p>Вы успешно авторизовались.</p>
                <p><a href='login_form.php'>Вернуться к форме</a></p>
            </div>
        </body>
        </html>";
    } else {
        // Если поля не заполнены
        echo "<p>Ошибка: не все поля заполнены</p>";
        echo "<a href='login_form.php'>Вернуться к форме</a>";
    }
} else {
    // Если кто-то пытается зайти напрямую
    header('Location: login_form.php');
    exit;
}
?>