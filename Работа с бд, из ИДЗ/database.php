<?php
/**
 * Конфигурация подключения к базе данных
 */

define('DB_HOST', 'localhost');
define('DB_NAME', 'izumi_market');
define('DB_USER', 'root');
define('DB_PASS', '1111');
define('DB_CHARSET', 'utf8mb4');

/**
 * Получить соединение с БД
 */
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES " . DB_CHARSET
        ]);
        return $pdo;
    } catch (PDOException $e) {
        die("Ошибка подключения к базе данных: " . $e->getMessage());
    }
}

/**
 * Выполнить запрос и вернуть результат
 */
function dbQuery($sql, $params = []) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt;
}

/**
 * Получить одну запись
 */
function dbFetchOne($sql, $params = []) {
    $stmt = dbQuery($sql, $params);
    return $stmt->fetch();
}

/**
 * Получить все записи
 */
function dbFetchAll($sql, $params = []) {
    $stmt = dbQuery($sql, $params);
    return $stmt->fetchAll();
}

/**
 * Получить количество записей
 */
function dbCount($sql, $params = []) {
    $stmt = dbQuery($sql, $params);
    return (int) $stmt->fetchColumn();
}

/**
 * Вставить запись и вернуть ID
 */
function dbInsert($table, $data) {
    $pdo = getDBConnection();
    $fields = array_keys($data);
    $placeholders = ':' . implode(', :', $fields);
    $sql = "INSERT INTO $table (" . implode(', ', $fields) . ") VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    return $pdo->lastInsertId();
}

/**
 * Обновить запись
 */
function dbUpdate($table, $data, $where, $whereParams = []) {
    $pdo = getDBConnection();
    $set = [];
    foreach (array_keys($data) as $field) {
        $set[] = "$field = :$field";
    }
    $sql = "UPDATE $table SET " . implode(', ', $set) . " WHERE $where";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array_merge($data, $whereParams));
    return $stmt->rowCount();
}

/**
 * Удалить запись
 */
function dbDelete($table, $where, $params = []) {
    $pdo = getDBConnection();
    $sql = "DELETE FROM $table WHERE $where";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    return $stmt->rowCount();
}