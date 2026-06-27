<!DOCTYPE html>
<html>
<head>
    <title>Чтение из файла</title>
</head>
<body>
    <h1>Чтение текстового файла</h1>

    <?php
    $filename = "1.txt";

    if (!file_exists($filename)) {
        echo "<p>❌ Файл $filename не найден.</p>";
    } else {
        // Чтение одной строки
        echo "<h2>📄 Первая строка:</h2>";
        $f = fopen($filename, "r");
        echo "<p>" . htmlspecialchars(fgets($f)) . "</p>";
        fclose($f);

        // Чтение всех строк
        echo "<h2>📄 Все строки:</h2>";
        $f = fopen($filename, "r");
        echo "<ul>";
        while (!feof($f)) {
            $line = fgets($f);
            if ($line !== false) {
                echo "<li>" . htmlspecialchars($line) . "</li>";
            }
        }
        echo "</ul>";
        fclose($f);
    }
    ?>
</body>
</html>