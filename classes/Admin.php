<?php

class Admin extends Db implements Person
{
    public function getStudents()
    {
        try{
            if (!isset($_SESSION['email'])) {
                header("location:login.php");
            }
            $sql = "SELECT * FROM students WHERE user_type = '0' ORDER BY id DESC";
            $statement = $this->connect()->prepare($sql);
            $statement->execute();
            $data = $statement->fetchAll();
            return $data;
        }catch(PDOException $ex){
            echo $ex;
        }
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
                    $password = $_POST["password"];
                    $query = "SELECT * FROM students WHERE email = :email";
                    $statement = $this->connect()->prepare($query);
                    $statement->bindValue(':email', $email);
                    // $statement->bindValue(':password', $password);
                    $statement->execute();

                    $data = $statement->fetchAll();
                    // $count = $statement->rowCount();
                    if (isset($data[0])){
                        if(password_verify($password, $data[0]->password)){
                            $_SESSION["email"] = $_POST["email"];
                            if ($data[0]->user_type == "1") {
                                header('location:admin.php');
                            } else {
    
                                header("location:home.php");
                            }
                        }else {
                            $message = '<label>Wrong Data</label>';
                            return $message;
                        }
                    }
                }
            }
        } catch (PDOException $ex) {
            echo $ex;
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
        } catch (PDOException $ex) {
            echo $ex();
        }
    }
}
