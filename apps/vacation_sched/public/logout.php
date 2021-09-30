<?php

$auth0 = require_once '../auth0.php';

$auth0->logout();
$return_to = 'http://' . $_SERVER['HTTP_HOST'];
$logout_url = sprintf('http://%s/v2/logout?client_id=%s&returnTo=%s', 'dev-6mg8d93k.us.auth0.com', 'SnuLvU0liWQxvnzMCgMKOCbjZT27y2Zk', $return_to);
header('Location: ' . $logout_url);

session_start();
session_destroy();