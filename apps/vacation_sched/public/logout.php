<?php

session_start();
session_destroy();

$auth0 = require_once '../auth0.php';

$auth0->logout();
$return_to = 'http://' . $_SERVER['HTTP_HOST'];
$logout_url = sprintf('http://%s/v2/logout?client_id=%s&returnTo=%s', $_ENV['AUTH0_DOMAIN'], $_ENV['AUTH0_CLIENT_ID'], $return_to);
header('Location: ' . $logout_url);