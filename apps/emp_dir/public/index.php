<h1>Employees directory App</h1>
<?php

session_start();

if (!isUserLoggedIn()) {
    header('Location: login.php');
    die;
}

$db = require_once 'connect.php';

