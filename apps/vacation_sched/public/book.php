<?php

session_start();
$sql = "UPDATE vacations SET employee_id = :uid WHERE id = :id";
$db = require_once '../connect.php';

$st = $db->prepare($sql);
$st->execute(
    [
        'uid' => $_SESSION['uid'],
        'id' => $_GET['id'],
    ]
);

header('Location: index.php');