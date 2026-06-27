<?php
/**
 * Задание 1: Передача данных через GET-запрос
 * Скрипт принимает параметры name и city из URL
 */

// Проверяем наличие параметров с помощью isset()
if (isset($_GET['name']) && isset($_GET['city'])) {
    // Получаем значения из GET-параметров и защищаем от XSS
    $name = htmlspecialchars($_GET['name']);
    $city = htmlspecialchars($_GET['city']);
    
    // Выводим приветствие
    echo "<h1>Результат GET-запроса</h1>";
    echo "<p>Пользователь <strong>$name</strong> проживает в городе <strong>$city</strong></p>";
} else {
    // Если параметры отсутствуют
    echo "<h1>Результат GET-запроса</h1>";
    echo "<p>Данные не указаны. Добавьте параметры name и city в URL.</p>";
    echo "<p>Пример:?name=Катя&city=Гродно</p>";
}


?>