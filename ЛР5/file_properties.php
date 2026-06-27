<!DOCTYPE html>
<html>
<head>
    <title>Файловая система</title>
</head>
<body>
    <h1>Свойства файла</h1>

    <?php
    $filename = "lesson14.php";

    if (file_exists($filename)) {
        echo "<p><strong>Файл:</strong> $filename</p>";
        echo "<p>Последнее изменение: " . date("r", filemtime($filename)) . "</p>";
        echo "<p>Последний доступ: " . date("r", fileatime($filename)) . "</p>";
        echo "<p>Размер: " . filesize($filename) . " байт</p>";
    } else {
        echo "<p>Файл $filename не найден.</p>";
    }
    ?>
</body>
</html>