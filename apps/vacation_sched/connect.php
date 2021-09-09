<?php


require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ );
$dotenv->load();

try {
    $db = new PDO('mysql:host='.$_ENV['DB_HOST'].';dbname='.$_ENV['DB_NAME'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);

    return $db;
} catch (Exception $exception) {
    die('Couldn\'t connect: '.$exception->getMessage());
}
