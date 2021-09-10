<?php

$auth0 = require_once '../auth0.php';

$userInfo = $auth0->getUser();

if (!$userInfo) {
    // We have no user info
    // See below for how to add a login link
    header('Location: login.php');
    die;
} else {
    ?>
    <head>
        <title>Leeway Academy's Vacation Scheduling App</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <div style="text-align: center">
        <img src="img/logo.png" height="52" width="190" class="text-center"/>
        <h1 class="text-center">Vacation scheduling App</h1>
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
    $db = require_once '../connect.php';

    if (!array_key_exists('uid', $_SESSION)) {
        $sql = "SELECT id FROM employees WHERE email = :email";
        $st = $db->prepare($sql);

        $st->execute(
            [
                    'email' => $userInfo['email']
            ]
        );

        $record = $st->fetch(PDO::FETCH_ASSOC);

        if ($record) {
            $_SESSION['uid'] = $record['id'];
        } else {
            die('Error: <b>'.$userInfo['email'].'</b> is not present in the local db');
        }
    }
    $sql = "SELECT * FROM vacations WHERE employee_id = :uid;";

    $st = $db->prepare($sql);
    $st->execute([
        'uid' => $_SESSION['uid'],
    ]);

    $record = $st->fetch(PDO::FETCH_ASSOC);

    if ($record) {
        ?>
        <p>You have reserved from <b><?php echo $record['start_date']; ?></b> until
            <b><?php echo $record['end_date']; ?></b></p>
        <a href="release.php">Cancel reservation</a>
        <?php
    } else {
        ?>
        <p>The following dates are available: </p>
        <?php
        $sql = "SELECT * FROM vacations WHERE employee_id IS NULL";
        $st = $db->prepare($sql);
        $st->execute();

        ?>
        <table>
            <thead>
            <tr>
                <th>Start date</th>
                <th>End date</th>
                <th>&nbsp;</th>
            </tr>
            </thead>
            <?php
            foreach ($st->fetchAll(PDO::FETCH_ASSOC) as $row) {
                ?>
                <tr>
                    <td><?php echo $row['start_date']; ?></td>
                    <td><?php echo $row['end_date']; ?></td>
                    <td><a href="book.php?id=<?php echo $row['id']; ?>">Book</a></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <?php
    }
}