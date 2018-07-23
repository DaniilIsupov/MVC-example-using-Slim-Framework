<?php

class AuthModel extends DataBase
{
    public function attempt($username, $password)
    {
        $user = UserModel::one($this->db, 'username', $username);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            $_SESSION['user'] = $user->getId();
            return $user;
        }

        return false;
    }

    public function logout()
    {
        $user = UserModel::one($this->db, 'id', (int) $_SESSION['user']);
        unset($_SESSION['user']);
    }

    public function user()
    {
        return isset($_SESSION['user']) ? UserModel::one($this->db, 'id', (int) $_SESSION['user']) : null;
    }

    public function check()
    {
        if (isset($_SESSION['user'])) {
            return true;
        }
        return false;
    }
}
