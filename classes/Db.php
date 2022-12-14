<?php

session_start();
class Db
{
    private $dbUsername = "root";
    private $dbPassword = "root";
    private $connection = "mysql:host=localhost; dbname=php_project; charset=utf8mb4";

    public function connect()
    {
        try {
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
            ];
            $db = new PDO($this->connection, $this->dbUsername, $this->dbPassword, $options);
            return $db;
        } catch (PDOException $ex) {
            echo $ex;
        }
    }
}
