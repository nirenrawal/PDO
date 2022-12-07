<?php
require_once('template/header.php');


$stundents = new Students();
$stundents->createProfile();

?>
<section class="pt-5">
  <div class="row">
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-4 text-center">Create a profile</h1>
        <p class="lead">Please enter your credentials to register.</p>
        <hr class="my-4">


        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
          <div class="form-group">
            <label for="name">Full Name</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Enter Full Name">
          </div>

          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input name="dob" type="date" class="form-control" id="dob">
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" type="text" class="form-control" id="address" placeholder="Enter Address"></textarea>
          </div>

          <div class="form-group">
            <label for="picture">Profile Picture</label>
            <input name="picture" type="file" class="form-control" id="picture">
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password">
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input name="confirmpassword" type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password">
          </div>

          <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('Are you sure, you want to register?'); window.location='login.php'">Register</button>
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once('template/footer.php'); ?>