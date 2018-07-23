<?php

class TodoController extends BaseController
{
    public function index($request, $response, $args)
    {
        $todos = TodoModel::all($this->db);
        return $this->view->render($response, 'todos.phtml', [
            'todos' => $todos,
            'router' => $this->router,
        ]);
    }
    public function addTodo($request, $response, $args)
    {
        $todo = new TodoModel([
            'text' => $request->getParsedBody()['new-todo-input'],
        ], $this->db);
        $todo->save();
        return $response->withRedirect('/todos');
    }
    public function deleteTodo($request, $response, $args)
    {
        $todo = TodoModel::one($this->db, $args['id']);
        $todo->delete();
        return $response->withRedirect('/todos');
    }
    public function crossTodo($request, $response, $args)
    {
        $todo = TodoModel::one($this->db, $args['id']);
        if ($todo->getCrossedOut() < 1) {
            $todo->setCrossedOut(1);
        } else {
            $todo->setCrossedOut(0);
        }
        $todo->update();
        return $response->withRedirect('/todos');
    }
    public function editTodo($request, $response, $args)
    {
        $todo = TodoModel::one($this->db, $request->getParsedBody()['id']);
        $todo->setText($request->getParsedBody()['text']);
        $todo->update();
        return $response->withRedirect('/todos');
    }
}
