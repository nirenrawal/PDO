<?php
$_title = 'Create Profile';
require_once __DIR__.'/template/header.php';


$student = new Students();
$msg = $student->createProfile();
?>
<script>function validatePassword() {
  if (
    document.getElementById("password").value !==
    document.getElementById("confirmpassword").value
  ) {
    alert("New Password and Confirm Password Field do not match  !!");
    document.getElementById("confirm-password").focus();
    return false;
  }
  return true;
}</script>

<section class="pt-5">
  <div class="row">
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-4 text-center">Create a profile</h1>
        <p class="lead">Please enter your credentials to register.</p>
        <hr class="my-4">


        <form method="post" action="<?php //echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data" onsubmit="return validatePassword();">
        <?php  if(isset($msg)){echo '<label class="text-danger">'.$msg.'</label>';}?>
       
        
          
          <div class="form-group">
            <label for="name">Full Name</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Enter Full Name" required>
            
          </div>

          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input name="dob" type="date" class="form-control" id="dob" required>
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" type="text" class="form-control" id="address" placeholder="Enter Address" required></textarea>
          
          </div>

          <div class="form-group">
            <label for="faculty">Faculty</label>
            <input name="faculty" type="text" class="form-control" placeholder="Enter Faculty" id="faculty" required>
          </div>

          <div class="form-group">
            <label for="school">School/University</label>
            <input name="school" type="text" class="form-control" placeholder="Enter School or University" id="school" required>
          </div>

          <div class="form-group">
            <label for="about">About me</label>
            <textarea name="about" type="text" class="form-control" id="about" placeholder="Write about yourself" required></textarea>
          </div>

          <div class="form-group">
            <label for="picture">Profile Picture</label>
            <input name="picture" type="file" class="form-control" id="picture" required>
          </div>

          <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password" required>
          </div>

          <div class="form-group">
            <label for="exampleInputPassword1">Confirm Password</label>
            <input name="confirmpassword" type="password" class="form-control" id="confirmpassword" placeholder="Confirm Password" required>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" >Register</button>
          <!-- onclick="return confirm('Are you sure, you want to register?'); window.location='login.php'" -->
        </form>
      </div>
    </div>
  </div>
</section>

<?php require_once __DIR__.'/template/footer.php'; ?>