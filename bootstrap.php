<?php
require '../vendor/autoload.php';

session_cache_limiter(false);
session_start();

$config = require '../config/config.php';
$app = new \Slim\App($config);

$container = $app->getContainer();

$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
$container['auth'] = function ($container) {
    return new AuthModel($container->db);
};

$container['view'] = new \Slim\Views\PhpRenderer('../view/');

// controllers
$container['TodoController'] = function ($container) {
    return new TodoController($container);
};
$container['AuthController'] = function ($container) {
    return new AuthController($container);
};
