<?php

try {
    $pdo = new \PDO($_ENV['DB_CONNECTION'] . ":host=" . 
        $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'], 
        $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    $pdo->exec("set names utf8");
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    header('HTTP/1.1 500 Internal server error');
    exit();
}