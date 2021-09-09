<?php

session_start();
$db = require_once '../connect.php';

$sql = "UPDATE vacations SET employee_id = NULL WHERE employee_id = :uid";

$st = $db->prepare($sql);
$st->execute([
    'uid' => $_SESSION['uid'],
]);

header('Location: index.php');