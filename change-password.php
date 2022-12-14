<?php
$_title = 'Change Password';
require_once __DIR__ . '/template/header.php';
$student = new Students();
?>

<section class="pt-5">
  <div class="row">
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-4 text-center">Change Password</h1>
        <hr class="my-4">

        <form method="POST" action="<?php $student->changePassowrd() ?>">

          <?php if (isset($_GET['error'])) { ?>
            <p class="error"><?php echo $_GET['error']; ?></p>
          <?php } ?>

          <?php if (isset($_GET['success'])) { ?>
            <p class="success"><?php echo $_GET['success']; ?></p>
          <?php } ?>


          <div class="form-group">
            <label for="oldpassword">Old Password</label>
            <input name="oldpassword" type="password" class="form-control" id="oldpassword" placeholder="Enter Your Current Password">
          </div>

          <div class="form-group">
            <label for="newpassword">New Password</label>
            <input name="newpassword" type="password" class="form-control" id="newpassword" placeholder="Enter A New Password">
          </div>

          <div class="form-group">
            <label for="confirmpassword">Confirm Password</label>
            <input name="confirmpassword" type="password" class="form-control" id="confirmpassword" placeholder="Enter Confirm Password">
          </div>

          <input type="submit" name="change" class="btn btn-info" value="Change Password" />
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once('template/footer.php'); ?>