<?php

session_start();
if (array_key_exists('uid', $_SESSION)) {
    header('Location: index.php');

    die;
}

if ('post' === strtolower($_SERVER['REQUEST_METHOD'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $sql = 'SELECT id FROM employees WHERE username = :username AND password = MD5(:password)';

    $db = require_once __DIR__ . '/../connect.php';

    $st = $db->prepare($sql);
    $st->execute(
        [
            'username' => $username,
            'password' => $password,
        ]
    );

    $records = $st->fetchAll();
    if ($records) {
        $record = current($records);
        $_SESSION['uid'] = $record['id'];

        header('Location: index.php');
        die;
    } else {
        http_response_code(403);
        echo 'Unauthorized access';
    }
} else {
    ?>
        <head>
            <title>Vacation Scheduling App</title>
        </head>
    <h1>Login</h1>
    <form method="post">
        <label for="username">Username:</label><input name="username" type="text" id="username"
                                                      placeholder="Enter your username"/>
        <label for="password">Password:</label> <input name="password" type="password" id="password"
                                                       placeholder="Enter your password"/>
        <input type="submit"/>
    </form>
    <?php
}