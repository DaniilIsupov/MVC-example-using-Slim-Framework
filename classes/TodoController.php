<?php
class TodoController extends DataBase
{
    public function getTodos()
    {
        $sql = "SELECT id, text, crossed_out FROM todos";
        $stmt = $this->db->query($sql);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new TodoModel($row);
        }
        return $results;
    }

    public function getTodoById($todo_id)
    {
        $sql = "SELECT id, text, crossed_out FROM todos WHERE id = " . intval($todo_id);
        $stmt = $this->db->query($sql);
        return new TodoModel($stmt->fetch());
    }

    public function save($todo)
    {
        $sql = "INSERT INTO todos (text, crossed_out) VALUES (:text, :crossed_out)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "text" => $todo->getText(),
            "crossed_out" => $todo->getCrossedOut(),
        ]);
        if (!$result) {
            throw new Exception("could not save record");
        }
    }
    public function delete($todo)
    {
        $sql = "DELETE FROM todos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "id" => $todo->getId(),
        ]);
        if (!$result) {
            throw new Exception("could not delete record");
        }
    }
    public function update($todo)
    {
        $sql = "UPDATE todos SET text = :text, crossed_out = :crossed_out WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "text" => $todo->getText(),
            "crossed_out" => $todo->getCrossedOut(),
            "id" => $todo->getId(),
        ]);
        if (!$result) {
            throw new Exception("could not delete record");
        }
    }
}
