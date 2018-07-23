<?php

class UserModel extends DataBase
{
    protected $id;
    protected $username;
    protected $password;

    public function __construct(array $data, $db)
    {
        if (isset($data['id'])) {
            $this->id = $data['id'];
        }
        $this->username = $data['username'];
        $this->password = $data['password'];
        $this->db = $db;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public static function all($db)
    {
        $sql = "SELECT * FROM users";
        $stmt = $db->query($sql);
        $results = [];
        while ($row = $stmt->fetch()) {
            $results[] = new UserModel($row, $db);
        }
        return $results;
    }
    public static function one($db, $key, $value)
    {
        $sql = "SELECT * FROM users WHERE " . $key . " = '" . $value . "'";
        $stmt = $db->query($sql);
        $user = $stmt->fetch();
        return $user ? new UserModel($user, $db) : null;
    }
    public function save()
    {
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            "username" => $this->username,
            "password" => $this->password,
        ]);
        if (!$result) {
            throw new Exception("could not save record");
        }
    }
}
