<?php

abstract class DataBase
{
    protected $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
}