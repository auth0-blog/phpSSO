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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
              integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x"
              crossorigin="anonymous">
        <title>Leeway Academy's Vacation Scheduling App</title>
    </head>
    <div style="text-align: center">
        <img src="img/logo.png" height="52" width="190" class="text-center"/>
        <h1 class="text-center">Leeway Academy's Vacation Scheduling App</h1>
    </div>
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