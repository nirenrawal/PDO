<?php
/*spl_autoload_register()
Defination
Calls a function when a class is loaded.
in other words, it says to the computer ....
(when you try to load a class) 
hey computer please do this-> **/
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
