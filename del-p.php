<?php
require_once __DIR__ . '/template/header.php';

$student = new Students();

// $student = $student->deleteProfile();


public function createProfile()
   {
      try {
         if(isset($_SESSION['email'])){
            header("Location:home.php");
         }
         if (!empty($_POST)) {
            if ($_FILES["picture"]["error"] > 0) {
               $msg = "File upload error";
            } else {
               $file_name = $_FILES["picture"]["name"];
               $upload_dir = "./images/profile_pictures";
               $tmp = explode('.', $file_name);
               $extension = end($tmp);
               $file_id = md5($_POST['email']) . "." . $extension;

               if ($extension == 'JPEG' || $extension == 'jpeg' || $extension == 'GIF' || $extension == 'gif' || $extension == 'PNG' || $extension == 'png' || $extension == 'JPG' || $extension == 'jpg') {
                  $user_type = '0';
                  $hash_key = sha1(microtime());
                  $name = $_POST['name'];
                  $dob = $_POST['dob'];
                  $address = $_POST['address'];
                  $faculty = $_POST['faculty'];
                  $school = $_POST['school'];
                  $about = $_POST['about'];
                  $email = $_POST['email'];
                  $password = sha1($_POST['password']);
                  $picture = $file_id;
                  $time = date('h:i A');
                  $date = date('Y-m-d');
                  $agent = $_SERVER['HTTP_USER_AGENT'];
                  $ip = $_SERVER['REMOTE_ADDR'];

                  $statement = $this->connect()->prepare('INSERT INTO students VALUES(:id, :user_type, :hash_key, :name, :dob, :address, :faculty, :school, :about, :email, :password, :picture, :time, :date, :agent, :ip)');

                  $statement->bindValue(':id', null);
                  $statement->bindValue(':user_type', $user_type);
                  $statement->bindValue(':hash_key', $hash_key);
                  $statement->bindValue(':name', $name);
                  $statement->bindValue(':dob', $dob);
                  $statement->bindValue(':address', $address);
                  $statement->bindValue(':faculty', $faculty);
                  $statement->bindValue(':school', $school);
                  $statement->bindValue(':about', $about);
                  $statement->bindValue(':email', $email);
                  $statement->bindValue(':password', $password);
                  $statement->bindValue(':picture', $picture);
                  $statement->bindValue(':time', $time);
                  $statement->bindValue(':date', $date);
                  $statement->bindValue(':agent', $agent);
                  $statement->bindValue(':ip', $ip);

                  $statement->execute();

                  if ($statement) {
                     move_uploaded_file($_FILES["picture"]["tmp_name"], $upload_dir . "/" . $file_id);
                     $msg = "Successfully Registered";
                     header('location:login.php');
                  } else {
                     $msg = "Account already exists";
                     return $msg;
                  }
               } else {
                  $msg = "You are trying to upload illegal file please check the file extenstion";
               }
            }
         }
      } catch (PDOException $ex) {
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