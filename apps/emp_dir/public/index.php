<?php

$auth0 = require_once '../auth0.php';

$userInfo = $auth0->getUser();

if (!$userInfo) {
    header('Location: login.php');
    die;
} else {
    ?>
        <head>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
            <title>Leeway Academy's Employees Directory App</title>
        </head>
    <div style="text-align: center">
        <img src="img/logo.png" height="52" width="190" class="text-center"/>
        <h1 class="text-center">Leeway Academy's Employees Directory App</h1>
    </div>
    <h2 class="text-end"><?php echo $userInfo['name'];?></h2>
    <?php if (array_key_exists('picture', $userInfo)) {
        ?>
        <div class="text-end"><img width="50px" height="50px" src="<?php echo $userInfo['picture'];?>"></div>
            <?php
    }?>
    <p class="text-end"><a href="logout.php">Logout</a> </p>
    <hr/>
    <?php
    $db = require_once __DIR__ . '/../connect.php';

    $sql = "SELECT e.name, e.email, d.name as department FROM employees e INNER JOIN departments d ON d.id = e.dept_id";

    if (($st = $db->prepare($sql)) === false) {
        die($db->errorInfo());
    }

    $st->execute();

    ?>
    <table style="border: 1px solid black; width: 100%; border-collapse: collapse;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Department</th>
        </tr>
        </thead>
        <tbody>
        <?php
        foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $employee) {
            ?>
            <tr>
                <td><?php echo $employee['name'];?></td>
                <td><?php echo $employee['email'];?></td>
                <td><?php echo $employee['department'];?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
    <?php
}