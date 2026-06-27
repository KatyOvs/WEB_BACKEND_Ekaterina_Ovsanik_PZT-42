<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Краткие примеры PHP</title>
   
</head>
<body>
    <?php
    mb_internal_encoding('UTF-8');

    echo "<h2>1. ТИПЫ ДАННЫХ</h2>";
    $int = 42;
    $float = 3.14;
    $string = "Привет";
    $bool = true;
    $null = null;
    $array = [1, 2, 3];

    var_dump($int);
    echo "<br>";
    var_dump($float);
    echo "<br>";
    var_dump($string);
    echo "<br>";
    var_dump($bool);
    echo "<br>";
    var_dump($null);
    echo "<br>";
    var_dump($array);
    echo "<br>";
    echo "gettype(int): " . gettype($int) . "<br>";
    echo "(string)float: " . (string)$float . "<br>";
    echo "is_int(int): " . (is_int($int) ? 'true' : 'false') . "<br>";
    echo "<hr>";

    echo "<h2>2. ОПЕРАЦИИ PHP</h2>";
    echo "10 + 5 = " . (10 + 5) . "<br>";
    echo "10 - 5 = " . (10 - 5) . "<br>";
    echo "10 * 5 = " . (10 * 5) . "<br>";
    echo "10 / 3 = " . (10 / 3) . "<br>";
    echo "10 % 3 = " . (10 % 3) . "<br>";
    echo "2 ** 3 = " . (2 ** 3) . "<br>";

    $i = 5;
    echo "\$i = 5<br>";
    echo "\$i++ = " . $i++ . ", после \$i = $i<br>";
    echo "++\$i = " . ++$i . ", после \$i = $i<br>";

    echo "Hello" . " " . "World" . "<br>";
    $str = "Hello";
    $str .= " World";
    echo $str . "<br>";

    echo "5 == \"5\": ";
    var_dump(5 == "5");
    echo "<br>";
    echo "5 === \"5\": ";
    var_dump(5 === "5");
    echo "<br>";
    echo "5 <=> 3: ";
    var_dump(5 <=> 3);
    echo "<br>";

    echo "true && false: ";
    var_dump(true && false);
    echo "<br>";
    echo "true || false: ";
    var_dump(true || false);
    echo "<br>";
    echo "!true: ";
    var_dump(!true);
    echo "<br>";
    echo "<hr>";

    echo "<h2>3. ОПЕРАТОРЫ PHP</h2>";
    $age = 22;
    if ($age < 18) {
        echo "ребёнок<br>";
    } elseif ($age <= 35) {
        echo "молодой<br>";
    } else {
        echo "взрослый<br>";
    }

    $access = ($age > 18) ? "разрешён" : "запрещён";
    echo "Доступ: $access<br>";

    echo "Цикл for: ";
    for ($i = 1; $i <= 5; $i++) {
        echo $i . " ";
    }
    echo "<br>";

    echo "Цикл while: ";
    $i = 1;
    while ($i <= 5) {
        echo $i . " ";
        $i++;
    }
    echo "<br>";

    $fruits = ["яблоко", "банан", "апельсин"];
    echo "foreach: ";
    foreach ($fruits as $fruit) {
        echo $fruit . " ";
    }
    echo "<br>";
    echo "<hr>";

    echo "<h2>4. ПОЛЬЗОВАТЕЛЬСКИЕ ФУНКЦИИ</h2>";
    function greet($name) {
        return "Привет, $name!";
    }
    echo greet("Иван") . "<br>";

    function sumAll(...$numbers) {
        return array_sum($numbers);
    }
    echo "sumAll(1,2,3,4,5) = " . sumAll(1, 2, 3, 4, 5) . "<br>";

    $numbers = [1, 2, 3, 4, 5];
    $squares = array_map(fn($n) => $n * $n, $numbers);
    echo "Квадраты: ";
    print_r($squares);
    echo "<br>";

    $even = array_filter($numbers, fn($n) => $n % 2 == 0);
    echo "Чётные: ";
    print_r($even);
    echo "<br>";

    function divide($a, $b) {
        if ($b == 0) return null;
        return $a / $b;
    }
    echo "10 / 2 = " . divide(10, 2) . "<br>";
    echo "10 / 0 = " . (divide(10, 0) === null ? 'null' : divide(10, 0)) . "<br>";
    echo "<hr>";

    echo "<h2>5. МАССИВЫ</h2>";
    $students = [
        ['name' => 'Анна', 'age' => 20, 'grade' => 4.5],
        ['name' => 'Иван', 'age' => 22, 'grade' => 3.8],
        ['name' => 'Мария', 'age' => 19, 'grade' => 4.9]
    ];

    $colors = ['red', 'green', 'blue'];
    $capitals = ['Россия' => 'Москва', 'Беларусь' => 'Минск'];

    echo "Третий студент: " . $students[2]['name'] . "<br>";
    echo "Первый цвет: " . $colors[0] . "<br>";
    echo "Столица России: " . $capitals['Россия'] . "<br>";

    array_push($colors, 'yellow');
    echo "После array_push: ";
    print_r($colors);
    echo "<br>";

    array_pop($colors);
    echo "После array_pop: ";
    print_r($colors);
    echo "<br>";

    array_shift($colors);
    echo "После array_shift: ";
    print_r($colors);
    echo "<br>";

    sort($colors);
    echo "После sort: ";
    print_r($colors);
    echo "<br>";

    ksort($capitals);
    echo "После ksort: ";
    print_r($capitals);
    echo "<br>";

    echo "in_array('red'): " . (in_array('red', $colors) ? 'true' : 'false') . "<br>";
    echo "array_search('green'): " . array_search('green', $colors) . "<br>";

    $slice = array_slice($colors, 0, 2);
    echo "array_slice: ";
    print_r($slice);
    echo "<br>";

    $merged = array_merge($colors, ['pink', 'brown']);
    echo "array_merge: ";
    print_r($merged);
    echo "<br>";

    $ages = array_column($students, 'age');
    echo "array_column: ";
    print_r($ages);
    echo "<br>";

    $filtered = array_filter($students, fn($s) => $s['age'] >= 21);
    echo "array_filter: ";
    print_r($filtered);
    echo "<br>";

    $names = array_map(fn($s) => $s['name'], $students);
    echo "array_map: ";
    print_r($names);
    echo "<br>";

    $sum = array_reduce($ages, fn($c, $v) => $c + $v, 0);
    echo "array_reduce сумма возрастов: $sum<br>";

    shuffle($colors);
    echo "shuffle: ";
    print_r($colors);
    echo "<br>";

    $rand = array_rand($colors, 2);
    echo "array_rand: " . $colors[$rand[0]] . ", " . $colors[$rand[1]] . "<br>";
    echo "<hr>";

    echo "<h2>6. СТРОКИ</h2>";
    $text = " PHP (Hypertext Preprocessor) ";
    $name = "Иван";

    echo "Одинарные кавычки: '\$name' = '$name'<br>";
    echo "Двойные кавычки: \"\$name\" = \"$name\"<br>";

    $heredoc = <<<EOD
    Heredoc:
    Многострочный текст
    Привет, $name
EOD;
    echo nl2br($heredoc) . "<br>";

    echo "Первый символ через [0]: '" . $text[0] . "'<br>";
    echo "Первый символ через mb_substr: '" . mb_substr($text, 0, 1) . "'<br>";

    echo "strlen: " . strlen($text) . "<br>";
    echo "mb_strlen: " . mb_strlen($text) . "<br>";

    echo "strpos('PHP'): " . strpos($text, 'PHP') . "<br>";
    echo "str_contains('PHP'): " . (str_contains($text, 'PHP') ? 'true' : 'false') . "<br>";
    echo "substr_count('P'): " . substr_count($text, 'P') . "<br>";

    echo "str_replace: " . str_replace('PHP', 'ПХП', $text) . "<br>";
    echo "trim: '" . trim($text) . "'<br>";
    echo "strtoupper: " . strtoupper($text) . "<br>";
    echo "strtolower: " . strtolower($text) . "<br>";

    $csv = "Иванов;Иван;ivan@mail.com;29;Минск";
    $data = explode(';', $csv);
    echo "explode: ";
    print_r($data);
    echo "<br>";
    echo "implode: " . implode('|', $data) . "<br>";

    $chars = str_split($text, 1);
    echo "str_split (первые 5): ";
    print_r(array_slice($chars, 0, 5));
    echo "<br>";

    $comment = "<b>Отличный сайт!</b> <script>alert('XSS');</script>";
    echo "htmlspecialchars: " . htmlspecialchars($comment) . "<br>";
    echo "strip_tags: " . strip_tags($comment) . "<br>";

    $price = " 1 234,56 руб. ";
    $clean = str_replace([' ', 'руб.'], '', trim($price));
    $clean = str_replace(',', '.', $clean);
    echo "Преобразование цены: " . (float)$clean . "<br>";
    echo "<hr>";

    echo "<h2>7. МАТЕМАТИЧЕСКИЕ ФУНКЦИИ</h2>";
    echo "abs(-15) = " . abs(-15) . "<br>";
    echo "ceil(4.3) = " . ceil(4.3) . "<br>";
    echo "floor(4.7) = " . floor(4.7) . "<br>";
    echo "round(3.14159, 2) = " . round(3.14159, 2) . "<br>";
    echo "rand(1, 100) = " . rand(1, 100) . "<br>";
    echo "max(34, 67, 12, 89) = " . max(34, 67, 12, 89) . "<br>";
    echo "min(34, 67, 12, 89) = " . min(34, 67, 12, 89) . "<br>";
    echo "<hr>";

    echo "<h2>8. ДАТА И ВРЕМЯ</h2>";
    echo "time(): " . time() . "<br>";
    echo "date('d.m.Y H:i:s'): " . date('d.m.Y H:i:s') . "<br>";
    echo "mktime(0,0,0,1,1,2026): " . mktime(0, 0, 0, 1, 1, 2026) . "<br>";
    echo "strtotime('next monday'): " . date('Y-m-d', strtotime('next monday')) . "<br>";
    echo "strtotime('+2 weeks'): " . date('Y-m-d', strtotime('+2 weeks')) . "<br>";

    $date1 = new DateTime('2026-02-11');
    $date2 = new DateTime('now');
    $diff = $date1->diff($date2);
    echo "Разница в днях: " . $diff->days . "<br>";
    ?>
</body>
</html>