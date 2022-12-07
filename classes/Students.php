<?php

class Students extends Db
{
   public function createProfile()
   {
      try {
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
                  $name = htmlspecialchars($_POST['name']);
                  $dob = htmlspecialchars($_POST['dob']);
                  $address = htmlspecialchars($_POST['address']);
                  $faculty = htmlspecialchars($_POST['faculty']);
                  $school = htmlspecialchars($_POST['school']);
                  $about = htmlspecialchars($_POST['about']);
                  $email = htmlspecialchars($_POST['email']);
                  $password = htmlspecialchars(sha1($_POST['password']));
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
                  } else {
                     $msg = "Account already exists";
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


   public function profilePage()
   {
      if (!isset($_SESSION['email'])) {
         header('location:login.php');
      }

      $email = $_SESSION['email'];
      // echo $email;
      $q = $this->connect()->prepare("SELECT * FROM students where email = :email");
      $q->bindValue(':email', $email);
      $q->execute();
      $data = $q->fetchAll();
      // print_r($data);
      return $data;
   }

   public function updateProfile()
   {
      if (!isset($_SESSION['email'])) {
         header("location:login.php");
      }
      if (!empty($_POST)) {
         $name = htmlspecialchars($_POST['name']);
         $dob = htmlspecialchars($_POST['dob']);
         $address = htmlspecialchars($_POST['address']);
         $faculty = htmlspecialchars($_POST['faculty']);
         $school = htmlspecialchars($_POST['school']);
         $about = htmlspecialchars($_POST['about']);
         $email = $_SESSION['email'];
         $statement = $this->connect()->prepare('UPDATE students VALUES(name = :name, dob = :dob, address = :address, faculty = :faculty, school = :school, about = :about, WHERE email = :email');
         $statement->bindValue(':name', $name);
         $statement->bindValue(':dob', $dob);
         $statement->bindValue(':address', $address);
         $statement->bindValue(':faculty', $faculty);
         $statement->bindValue(':school', $school);
         $statement->bindValue(':about', $about);
         $statement->bindValue(':email', $email);
         $statement->execute();

      $sql = "SELECT * FROM students WHERE email = $email";
        $statement = $this->connect()->prepare($sql);
        $statement->execute();
      }
   }



   public function getSession()
   {
      if (isset($_SESSION['email'])) {
         return $_SESSION['email'];
      }
      return null;
   }




   public function deleteSession()
   {
      if (isset($_SESSION['email'])) {

         unset($_SESSION['email']);
         session_destroy();
         header('location:login.php');
      }
   }
}
