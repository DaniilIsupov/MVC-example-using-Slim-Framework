<?php

class TodoModel extends DataBase
{
    protected $id;
    protected $text;
    protected $crossed_out = 0;

    public function __construct(array $data, $db)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        $this->text = $data['text']; // required
        if (isset($data['id'])) {
            $this->crossed_out = $data['crossed_out'];
        }
        $this->db = $db;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getText()
    {
        return $this->text;
    }
    public function setText($text)
    {
        $this->text = $text;
    }
    public function getCrossedOut()
    {
        return $this->crossed_out;
    }
    public function setCrossedOut($crossed_out)
    {
        $this->crossed_out = $crossed_out;
    }

    public static function all($db)
    {
        $sql = "SELECT * FROM todos";
        $stmt = $db->query($sql);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new TodoModel($row, $db);
        }
        return $results;
    }
    public static function one($db, $todo_id)
    {
        $sql = "SELECT * FROM todos WHERE id = " . intval($todo_id);
        $stmt = $db->query($sql);
        return new TodoModel($stmt->fetch(), $db);
    }
    public function save()
    {
        $sql = "INSERT INTO todos (text, crossed_out) VALUES (:text, :crossed_out)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "text" => $this->text,
            "crossed_out" => $this->crossed_out,
        ]);
        if (!$result) {
            throw new Exception("could not save record");
        }
    }
    public function delete()
    {
        $sql = "DELETE FROM todos WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "id" => $this->id,
        ]);
        if (!$result) {
            throw new Exception("could not delete record");
        }
    }
    public function update()
    {
        $sql = "UPDATE todos SET text = :text, crossed_out = :crossed_out WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "text" => $this->text,
            "crossed_out" => $this->crossed_out,
            "id" => $this->id,
        ]);
        if (!$result) {
            throw new Exception("could not update record");
        }
    }
}
