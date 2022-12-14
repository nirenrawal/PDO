<?php

class Students extends Db
{
   public function createProfile()
   {
      try {
         if (isset($_SESSION['email'])) {
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
                  $password = $_POST['password'];
                  $password_hash = password_hash($password, PASSWORD_DEFAULT);
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
                  $statement->bindValue(':password', $password_hash);
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




   public function profilePage()
   {
      if (!isset($_SESSION['email'])) {
         header('location:login.php');
      }
      $email = $_SESSION['email'];
      $q = $this->connect()->prepare("SELECT * FROM students where email = :email");
      $q->bindValue(':email', $email);
      $q->execute();
      $data = $q->fetchAll();
      return $data;
   }



   public function updateProfile()
   {
      try {
         if (isset($_SESSION['email'])) {
            if (isset($_POST['name']) && isset($_POST['dob']) && isset($_POST['address']) && isset($_POST['faculty']) && isset($_POST['school']) && isset($_POST['about'])) {
               function validate($data)
               {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
               }
               $name = validate($_POST['name']);
               $dob = validate($_POST['dob']);
               $address = validate($_POST['address']);
               $faculty = validate($_POST['faculty']);
               $school = validate($_POST['school']);
               $about = validate($_POST['about']);
               $date = date('Y-m-d');
               $email = $_SESSION['email'];
               $statement = $this->connect()->prepare('UPDATE students  SET name = :name, dob = :dob, address = :address, faculty = :faculty, school = :school, about = :about, date = :date WHERE email = :email');
               $statement->bindValue(':name', $name);
               $statement->bindValue(':dob', $dob);
               $statement->bindValue(':address', $address);
               $statement->bindValue(':faculty', $faculty);
               $statement->bindValue(':school', $school);
               $statement->bindValue(':about', $about);
               $statement->bindValue(':date', $date);
               $statement->bindValue(':email', $email);
               $statement->execute();
               $count = $statement->rowCount();

               if ($count == 1) {
                  header("location:home.php");
               } else {
                  echo "Failed !";
               }
            }
         }
      } catch (PDOException $ex) {
         echo $ex;
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

   public function uploadPicture()
   {
      try {
         if (!empty($_POST)) {
            if ($_FILES["picture"]["error"] > 0) {
               $msg = "File upload error";
            } else {
               $email = $_SESSION['email'];

               $file_name = $_FILES["picture"]["name"];
               $upload_dir = "./images/profile_pictures";
               $tmp = explode('.', $file_name);
               $extension = end($tmp);
               $file_id = md5($email) . "." . $extension;

               if ($extension == 'JPEG' || $extension == 'jpeg' || $extension == 'GIF' || $extension == 'gif' || $extension == 'PNG' || $extension == 'png' || $extension == 'JPG' || $extension == 'jpg') {
                  $picture = $file_id;

                  $statement = $this->connect()->prepare('UPDATE students SET picture = :picture WHERE email = :email');

                  $statement->bindValue(':picture', $picture);
                  $statement->bindValue(':email', $email);
                  $statement->execute();
                  $count = $statement->rowCount();

                  if ($count == 1) {
                     echo 'success';
                     header("location:home.php");
                  } else {
                     echo "Failed !";
                  }
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




   public function changePassowrd()
   {
      try {
         if (isset($_SESSION['email'])) {
            if (isset($_POST['oldpassword']) && isset($_POST['newpassword']) && isset($_POST['confirmpassword'])) {
               function validate($data)
               {
                  $data = trim($data);
                  $data = stripslashes($data);
                  $data = htmlspecialchars($data);
                  return $data;
               }
               $old = validate($_POST['oldpassword']);
               $new = validate($_POST['newpassword']);
               $confirm = validate(($_POST['confirmpassword']));

               if (empty($old)) {
                  header("Location:change-password.php?error=Old Password is required.");
                  exit();
               } elseif (empty($new)) {
                  header("Location:change-password.php?error=New Password is required.");
                  exit();
               } elseif ($new !== $confirm) {
                  header("Location:change-password.php?error=New Password and confirm password doesn't match.");
                  exit();
               } else {
                  $old = password_hash($old, PASSWORD_DEFAULT);
                  $new = password_hash($new, PASSWORD_DEFAULT);
                  $email = $_SESSION['email'];

                  $sql = "SELECT password FROM students WHERE email = :email and password = :password";

                  $query = $this->connect()->prepare($sql);
                  $query->bindValue(':password', $old);
                  $query->bindValue(':email', $email);
                  $query->execute();
                  $count = $query->rowCount();
                  echo $count;
                  if ($count === 1) {
                     $connection = "UPDATE students SET password = :newpassword WHERE email = :email";
                     $pass = $this->connect()->prepare($connection);
                     $pass->bindValue(':email', $email);
                     $pass->bindValue(':newpassword', $new);
                     $pass->execute();
                     header("Location: change-password.php?success=Your password has been changed successfully");
                     exit();
                  } else {
                     header("Location: change-password.php?error=Incorrect password");
                  }
               }
            // } else {
            //    //  header("Location: change-password.php");
            //    //  exit();
            }
         } else {
            header("Location: home.php");
            exit();
         }
      } catch (PDOException $ex) {
         echo $ex;
      }
   }


   public function delProfile()
   {
      if (!isset($_SESSION['email'])) {
         header("location:login.php");
      }
      try {
        
         $email = $_SESSION['email'];
         $sql = 'DELETE FROM students WHERE email = :email';
         $stmt = $this->connect()->prepare($sql);
         $stmt->bindValue(':email', $email);
         $stmt->execute();
         // $count = $stmt->rowCount();
         if ($stmt->execute()) {
            header("Location:logout.php");
         }else{
            header("Location:home.php");
         }
         // $s = mysqli_fetch_array(mysqli_query($al, "SELECT * FROM students WHERE email = '" . $_SESSION['email'] . "' "));
         // if (!empty($_POST)) {
         //    if (sha1($_POST['p']) == $s_['password']) {
         //       $sql = mysqli_query($al, "DELETE FROM students WHERE email = '" . $_SESSION['email'] . "'");
         //       if ($sql) {
         //             header("location:logout.php");
         //       }
         //    }

      } catch (PDOException $ex) {
         echo $ex;
      }
   }
}
