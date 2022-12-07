<?php
require_once('template/header.php');

$admin = new Admin();
$msg = $admin->login();


// if (isset($_SESSION["email"])) {
//   header('location:home.php');
// }

?>
<section class="pt-5">
  <div class="row">
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-4 text-center">Log In</h1>
        <p class="lead">Please Enter your email address and password.</p>
        <hr class="my-4">



        <form method="post">
          <?php  if(isset($msg))  
                {  
                     echo '<label class="text-danger">'.$msg.'</label>';  
                }   ?>
          <div class="form-group">
            <label for="email">Email address</label>
            <input name="email" type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password">
          </div>

          <input type="submit" name="login" class="btn btn-info" value="Login" />
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once('template/footer.php'); ?>