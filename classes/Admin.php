<?php

class Admin extends Db
{
    public function getStudents()
    {
        if (!isset($_SESSION['email'])) {
            header("location:login.php");
        }
        $sql = "SELECT * FROM students WHERE user_type = '0' ORDER BY id DESC";
        $statement = $this->connect()->prepare($sql);
        $statement->execute();
        $data = $statement->fetchAll();
        return $data;
    }


    public function login()
    {
        $message = '';
        try {
            if (isset($_POST["login"])) {
                if (empty($_POST["email"]) || empty($_POST["password"])) {
                    $message = '<label>All fields are required</label>';
                    return $message;
                } else {
                    $email =  $_POST["email"];
                    $password = sha1($_POST["password"]);
                    $query = "SELECT * FROM students WHERE email = :email AND password = :password";
                    $statement = $this->connect()->prepare($query);
                    $statement->bindValue(':email', $email);
                    $statement->bindValue(':password', $password);
                    $statement->execute();

                    $data = $statement->fetch();
                    $count = $statement->rowCount();

                    if ($count == 1) {

                        $_SESSION["email"] = $_POST["email"];
                        if ($data->user_type == "1") {
                            header('location:admin.php');
                        } else {

                            header("location:home.php");
                        }
                    } else {
                        $message = '<label>Wrong Data</label>';
                        return $message;
                    }
                }
            }
        } catch (PDOException $error) {
            $message = $error->getMessage();
        }
    }



    public function delete()
    {
        if (!isset($_SESSION['email'])) {
            header('location:login.php');
        }
        try {
            if (isset($_POST["delete"])) {
                $id = $_POST['id'];
                echo $id;
                $sql = 'DELETE FROM students 
                    WHERE id = :id';

                $stmt = $this->connect()->prepare($sql);
                $stmt->bindValue(':id', $id);

                $stmt->execute();

                $count = $stmt->rowCount();
                if ($count == 1) {
                    header('location:admin.php');
                } else {
                    echo 'failed';
                }
            }
        } catch (PDOException $error) {
            $message = $error->getMessage();
        }
    }
}
