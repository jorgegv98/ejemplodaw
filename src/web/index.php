<?php

try {
require __DIR__ . '/vendor/autoload.php';

//librería para poder leer archivos.env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $pdo = new \PDO($_ENV['DB_CONNECTION'] . ":host=" . 
        $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_DATABASE'], 
        $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    $pdo->exec("set names utf8");
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Exception PDO"
    echo $e->getMessage();
    exit();
}

$sql = "SELECT * FROM peliculas WHERE id = :id";

$params = [
    ":id" => 2
];

$ps = $pdo->prepare($sql);
$ps->execute($params);
$result = $ps->columnCount()>0? $ps->fetchAll(\PDO::FETCH_ASSOC): $ps->rowCount(); 

echo '<h1>resultado</h1>';
var_dump($result); 
} catch (Exception $e) {
    echo "Exception"
    echo $e->getMessage();
}
