<!DOCTYPE html>
<html>
<head>
    <title>Запись в файл</title>
</head>
<body>
    <h1>Запись в текстовый файл</h1>

    <?php
    $filename = "textfile.txt";

    // ========== 4.1: Запись строки (перезапись) ==========
    echo "<h2>Запись строки (режим 'w'):</h2>";
    $f = fopen($filename, "w");
    fwrite($f, "PHP is fun!");
    fclose($f);

    // Проверка
    $f = fopen($filename, "r");
    echo "<p>Содержимое файла: <strong>" . htmlspecialchars(fgets($f)) . "</strong></p>";
    fclose($f);

    // ========== 4.2: Добавление текста из формы ==========
    echo "<h2>Добавление текста (режим 'a'):</h2>";
    ?>

    <form method="post">
        <textarea name="textblock" rows="4" cols="50" placeholder="Введите текст для добавления..."></textarea>
        <br><br>
        <input type="submit" value="Добавить в файл">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($_POST["textblock"])) {
        // Добавление в конец файла
        $f = fopen($filename, "a");
        fwrite($f, "\n" . $_POST["textblock"]);
        fclose($f);

        // Показать обновленное содержимое
        echo "<h3>Обновленное содержимое файла:</h3>";
        echo "<pre>";
        echo htmlspecialchars(file_get_contents($filename));
        echo "</pre>";
    }

    // Показываем текущее содержимое
    echo "<h3>Текущее содержимое файла:</h3>";
    echo "<pre>";
    echo htmlspecialchars(file_get_contents($filename));
    echo "</pre>";
    ?>
</body>
</html>