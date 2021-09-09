<?php

session_start();

if (!isUserLoggedIn()) {
    header('Location: login.php');
    die;
}

$db = require_once __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'connect.php';

$sql = "SELECT e.name, e.email, d.name as department FROM employees e INNER JOIN departments d ON d.id = e.dept_id";

if (($st = $db->prepare($sql)) === false) {
    die($db->errorInfo());
}

$st->execute();

?>
<head>
    <title>Employee's Directory App</title>
</head>
<h1>Employee's directory</h1>
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
<p><a href="logout.php">Logout</a> </p>
<?php

function isUserLoggedIn() : bool
{
    return !empty($_SESSION['uid']);
}