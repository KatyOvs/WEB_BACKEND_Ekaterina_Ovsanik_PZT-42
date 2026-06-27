<!DOCTYPE html>
<html>
<head>
    <title>Содержимое папки</title>
</head>
<body>
    <h1>Список файлов в папке</h1>

    <?php
    // Используем папку относительно текущего скрипта
    $dir = __DIR__ . "/tutorials/php/";

    // Или просто относительный путь:
    // $dir = "tutorials/php/";

    if (!is_dir($dir)) {
        echo "<p>Папка не найдена: $dir</p>";
        echo "<p>Создайте папку <code>tutorials/php/</code> в той же директории, что и этот скрипт.</p>";
    } else {
        echo "<h2>Папка: $dir</h2>";
        echo "<ul>";
        
        $folder = opendir($dir);
        while (($entry = readdir($folder)) !== false) {
            // Пропускаем текущую и родительскую папки
            if ($entry != "." && $entry != "..") {
                echo "<li>" . htmlspecialchars($entry) . "</li>";
            }
        }
        closedir($folder);
        
        echo "</ul>";
    }
    ?>
</body>
</html>