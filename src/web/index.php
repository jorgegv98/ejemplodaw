<?php

try {
require __DIR__ . '/vendor/autoload.php';

//librería para poder leer archivos.env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $pdo = new \PDO($_ENV['DB_CONNECTION'] . ":host=" . 
        $_ENV['DB_HOST'] .";port=". $_ENV['DB_PORT'] .";dbname=" . $_ENV['DB_DATABASE'], 
        $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD']);
    $pdo->exec("set names utf8");
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Exception PDO";
    echo $e->getMessage();
    exit();
}

$sql = "SELECT * FROM info";



$ps = $pdo->prepare($sql);
$ps->execute();
$result = $ps->columnCount()>0? $ps->fetchAll(\PDO::FETCH_ASSOC): $ps->rowCount(); 
echo '<head>';
        echo '<link rel="stylesheet" type="text/css" href="css/main.css"/>';
    echo '</head>';

echo '<h1>Ejercicio 7</h1>';
    echo '<div class="g--background-color-principal-1">JORGE GARCIA</div>';
    echo 'Contenido de base de datos: '.$result;

var_dump($result); 
} catch (Exception $e) {
    echo "Exception";
    echo $e->getMessage();
}
