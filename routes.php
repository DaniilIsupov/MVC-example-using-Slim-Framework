<?php

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'home.phtml');
})->add(new AuthMiddleware($container));

$app->group('/todos', function () use ($app) {
    $app->get('', 'TodoController:index')->setName('todos');
    $app->post('/add', 'TodoController:addTodo')->setName('addTodo');
    $app->post('/delete/{id}', 'TodoController:deleteTodo')->setName('deleteTodo');
    $app->post('/cross/{id}', 'TodoController:crossTodo')->setName('crossTodo');
    $app->post('/edit', 'TodoController:editTodo')->setName('editTodo');
})->add(new AuthMiddleware($container));

$app->get('/login', 'AuthController:login')->setName('login');
$app->post('/login', 'AuthController:postLogin');
$app->get('/logout', 'AuthController:logout')->setName('logout');
