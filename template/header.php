<?php
include "./includes/autoload.php";
$stundents = new Students();
$session = $stundents->getSession();
// echo $session;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- font awsome-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!--Bootstrap-->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.2.1/dist/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
  <!-- google fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">

  <link rel="stylesheet" href="styles/style.css">
  <title><?= $_title ?? 'Real Estate' ?></title>
  
</head>

<body>
  <section>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <a class="navbar-brand" href="#">StudentBook</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
        <div class="navbar-nav">


          <?php if (isset($session)) { ?>
            <a class="nav-item nav-link" href="./home.php">Home</a><?php } ?>

          <?php if (!isset($session)) { ?>
            <a class="nav-item nav-link" href="./create-profile.php">Create Profile</a><?php } ?>

          <?php if (isset($session)) { ?>
            <a class="nav-item nav-link" href="./logout.php">Logout</a><?php } ?>

          <?php if (!isset($session)) { ?>
            <a class="nav-item nav-link" href="./login.php">Login</a><?php } ?>
          
          <?php if (isset($session)) { ?>
            <a class="nav-item nav-link" href="./change-password.php">Change Password</a><?php } ?>


        </div>
      </div>

    </nav>
  </section>