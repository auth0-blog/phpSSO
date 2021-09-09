<?php


require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();

try {
    $db = new PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME'), getenv('DB_USER'), getenv('DB_PASSWORD'));

    return $db;
} catch (Exception $exception) {
    die('Couldn\'t connect: '.$exception->getMessage());
}
