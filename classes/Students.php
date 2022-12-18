<?php

class Students extends Db 
{
   public function createProfile()
   {
      $msg = '';
      $regex = '/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/';
      try {
         if (isset($_SESSION['email'])) {
            header("Location:home.php");
         }
         if (!empty($_POST)) {
            if ($_FILES["picture"]["error"] > 0) {
               $msg = "File upload error";
               return $msg;
            } else {
               $file_name = $_FILES["picture"]["name"];
               $upload_dir = "./images/profile_pictures";
               $tmp = explode('.', $file_name);
               $extension = end($tmp);
               $file_id = md5($_POST['email']) . "." . $extension;

               if ($extension == 'JPEG' || $extension == 'jpeg' || $extension == 'GIF' || $extension == 'gif' || $extension == 'PNG' || $extension == 'png' || $extension == 'JPG' || $extension == 'jpg') {
                  // if(isset($_POST['submit'])){
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

                  if(strlen($name) <=2){
                     $msg_name= 'Full name must be minimum 2 characters long.';
                     return $msg_name;
                  }elseif(strlen($address) <= 8){
                     $msg= 'Address must be minimum 8 characters long.';
                     return $msg;
                  }elseif(!preg_match($regex, $email)){
                     $msg="Please enter a valid email address";
                     return $msg;
                  }elseif(strlen($faculty) <=2){
                     $msg= 'Faculty must be minimum 2 characters long.';
                     return $msg;
                  }elseif(strlen($school) <=2){
                     $msg= 'School must be minimum 2 characters long.';
                     return $msg;
                  }elseif(strlen($school) <=1){
                     $msg= "'About me' cannot be empty.";
                     return $msg;
                  }elseif(strlen($password) <= 6){
                     $msg= 'Password must be 6 characters long';
                     return $msg;
                  }
                  else{

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
               }
               } else {
                  $msg = "You are trying to upload illegal file please check the file extenstion";
                  return $msg;
               }
            }
         }
      } catch (PDOException $ex) {
         echo $ex;
      }
   }

//************************************************************************************************/


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


//************************************************************************************************/
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

//************************************************************************************************/

   public function getSession()
   {
      if (isset($_SESSION['email'])) {
         return $_SESSION['email'];
      }
      return null;
   }


//************************************************************************************************/

   public function deleteSession()
   {
      if (isset($_SESSION['email'])) {

         unset($_SESSION['email']);
         session_destroy();
         header('location:login.php');
      }
   }


//************************************************************************************************/

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

                  if ($statement->execute()) {
                     move_uploaded_file($_FILES["picture"]["tmp_name"], $upload_dir . "/" . $file_id);
                     header("location:home.php");
                  } else {
                     echo "Failed !";
                  }
               } else {
                  echo "You are trying to upload illegal file please check the file extenstion";
               }
            }
         }
      } catch (PDOException $ex) {
         echo $ex;
      }
   }

//************************************************************************************************/

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
               } elseif(!empty($new) && strlen($new) <= 6){
                  header("Location:change-password.php?error=Password must be 6 characters long.");
                  exit();
               }elseif ($new !== $confirm) {
                  header("Location:change-password.php?error=New Password and confirm password doesn't match.");
                  exit();
               } else {
                  $email = $_SESSION['email'];
                  $sql = "SELECT password FROM students WHERE email = :email";
                  $query = $this->connect()->prepare($sql);
                  $query->bindValue(':email', $email);
                  $query->execute();
                  $count = $query->rowCount();
                  if ($count == 1) {
                     $result = $query->fetch();
                     if (password_verify($old, $result->password)) {
                        if ($new == $confirm) {
                           $connection = "UPDATE students SET password = :newpassword WHERE email = :email";
                           $hash = password_hash($confirm, PASSWORD_DEFAULT);
                           $pass = $this->connect()->prepare($connection);
                           $pass->bindValue(':email', $email);
                           $pass->bindValue(':newpassword', $hash);
                           $pass->execute();
                           header("Location: change-password.php?success=Your password has been changed successfully");
                           exit();
                        }
                     } else {
                        header("Location: change-password.php?error=Incorrect password");
                     }
                  }
               }
            } else {
            }
         } else {
            header("Location: home.php");
            exit();
         }
      } catch (PDOException $ex) {
         echo $ex;
      }
   }
//************************************************************************************************/

   public function delete()
   {
      if (!isset($_SESSION['email'])) {
         header("location:login.php");
      }
      try {
         if (isset($_POST["delete"])) {
            $id = $_POST['id'];
            $sql = 'DELETE FROM students WHERE id = :id';
            $stmt = $this->connect()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $count = $stmt->rowCount();
            if ($count == 1) {
               header("Location:logout.php");
            } else {
               header("Location:home.php");
            }
         }
      } catch (PDOException $ex) {
         echo $ex;
      }
   }
}
