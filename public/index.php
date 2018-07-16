<?php
require '../vendor/autoload.php';

$settings['displayErrorDetails'] = true;
$settings['addContentLengthHeader'] = false;

$settings['db']['host'] = 'localhost';
$settings['db']['user'] = 'root';
$settings['db']['pass'] = '1234';
$settings['db']['dbname'] = 'lessons';
$config = ['settings' => $settings];
$app = new \Slim\App($config);

$container = $app->getContainer();

// $container['logger'] = function ($c) {
//     $logger = new \Monolog\Logger('my_logger');
//     $file_handler = new \Monolog\Handler\StreamHandler('../logs/app.log');
//     $logger->pushHandler($file_handler);
//     return $logger;
// };
$container['db'] = function ($c) {
    $db = $c['settings']['db'];
    $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'],
        $db['user'], $db['pass']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
$container['view'] = new \Slim\Views\PhpRenderer('../view/');

$app->get('/', function ($request, $response, $args) {
    // $request->getUri();
    return $response->write('<p><a href="/todos">Todos</a></p>');
});

$app->group('/todos', function () use ($app) {
    $app->get('', function ($request, $response, $args) {
        $mapper = new TodoController($this->db);
        $todos = $mapper->getTodos();
        $response = $this->view->render($response, 'todos.phtml', ['todos' => $todos, "router" => $this->router]);
        return $response;
    });
    $app->post('/add', function ($request, $response, $args) {
        $body = $request->getParsedBody();
        $mapper = new TodoController($this->db);
        $todo = new TodoModel(['text' => $body['new-todo-input']]);
        $mapper->save($todo);
        return $response->withRedirect('/todos');
    });
    $app->post('/delete/{id}', function ($request, $response, $args) {
        $mapper = new TodoController($this->db);
        $todo = $mapper->getTodoById($args['id']);
        $mapper->delete($todo);
        return $response->withRedirect('/todos');
    });
    $app->post('/cross/{id}', function ($request, $response, $args) {
        $mapper = new TodoController($this->db);
        $todo = $mapper->getTodoById($args['id']);
        if ($todo->getCrossedOut() < 1) {
            $todo->setCrossedOut(1);
        } else {
            $todo->setCrossedOut(0);
        }
        $mapper->update($todo);
        return $response->withRedirect('/todos');
    });
    $app->post('/edit', function ($request, $response, $args) {
        $body = $request->getParsedBody();
        $mapper = new TodoController($this->db);
        $todo = $mapper->getTodoById($body['id']);
        $todo->setText($body['text']);
        $mapper->update($todo);
        return $response->withRedirect('/todos');
    });
});

// Run app
$app->run();
