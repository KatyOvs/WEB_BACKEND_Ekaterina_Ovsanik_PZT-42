<!DOCTYPE html>
<html>
    <head>
        <title>Первый пример</title>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251"/>
        <link href="css/styles.css" rel="stylesheet" type="text/css"/>    
    </head>
    <body>

        <?php
       
      phpinfo();
      // Использование echo
      echo "<p>Привет всем!!! Меня зовут Екатерина и я учусь на 3 курсе </p>";
     
      // Использование print (возвращает 1)
    print "<p>Это вывод с помощью оператора print.</p>";

    // 2. Переменные разных типов, предопределенные переменные
        echo "<h2>2. Переменные разных типов</h2>";
        
        // разные типы
        $integer_var = 42;
        $float_var = 3.14;
        $string_var = "Hello";           
        $bool_var = true;                 
        $null_var = null;  

        $array_var = array(1, 2, 3, "четыре");
        
        echo "Целое число: " . $integer_var . "<br>";
        echo "Дробное число: " . $float_var . "<br>";
        echo "Строка: " . $string_var . "<br>";
        echo "Булево значение: " . ($bool_var ? 'true' : 'false') . "<br>";
        echo "null-значение: " . (is_null($null_var) ? 'NULL' : 'не NULL') . "<br>";
        echo "Массив: ";
        print_r($array_var);
        echo "<br>";

        //предопределенные переменные
        echo "IP-адрес клиента: " . $_SERVER['REMOTE_ADDR'] . "<br>";
        echo "Имя файла скрипта: " . $_SERVER['PHP_SELF'] . "<br>";

        //ПРЕДопределененные константы
        echo "Текущая версия PHP: " . PHP_VERSION . "<br>";
        echo "Операционная система: " . PHP_OS . "<br>";
      


        $title = "Наша первая динамическая страница";
        $user_name = "User";
        define('PI', 3.141592); //ОПРЕДЕЛЕНИЕ КОНСТАНТЫ
        echo "<p>"."Ваше имя: ".$user_name."</p>";
        echo "<p>"."Дата: ".date("d-m-Y")."</p>";
        echo "<p>"."Константа pi = : ".PI."</p>";
  ?>

    </body>
</html>