<?php
$_title = 'Update Profile';
require_once __DIR__.'/template/header.php';

$student = new Students();
$data = $student->profilePage();
?>


<section class="pt-5">
  <div class="row">
    <div class="container">
      <div class="jumbotron">
        <h1 class="display-4 text-center">Update Your Profile</h1>
        <hr class="my-4">
        <?php  if(isset($msg)){echo '<label class="text-danger">'.$msg.'</label>';}?>
        <form method="post" action="<?php $student->updateProfile() ?>" enctype="multipart/form-data">
       
          <div class="form-group">
            <label for="name">Full Name</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="Enter Full Name" value="<?= htmlspecialchars($data[0]->name); ?>">
          </div>

          <div class="form-group">
            <label for="dob">Date of Birth</label>
            <input name="dob" type="date" class="form-control" id="dob" value="<?= htmlspecialchars($data[0]->dob); ?>">
          </div>

          <div class="form-group">
            <label for="address">Address</label>
            <textarea name="address" type="text" class="form-control" id="address" placeholder="Enter Address"><?= htmlspecialchars($data[0]->address); ?></textarea>
          </div>

          <div class="form-group">
            <label for="faculty">Faculty</label>
            <input name="faculty" type="text" class="form-control" placeholder="Enter Faculty" id="faculty" value="<?= htmlspecialchars($data[0]->faculty); ?>">
          </div>

          <div class="form-group">
            <label for="school">School/University</label>
            <input name="school" type="text" class="form-control" placeholder="Enter School or University" id="school" value="<?= htmlspecialchars($data[0]->school); ?>">
          </div>

          <div class="form-group">
            <label for="about">About me</label>
            <textarea name="about" type="text" class="form-control" id="about" placeholder="Write about yourself"><?= htmlspecialchars($data[0]->about); ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary btn-lg" onclick="return confirm('Are you sure, you want to Update your profile?'); window.location='update-profile.php'">Update</button>
        </form>
      </div>
    </div>
  </div>
</section>


<?php require_once __DIR__.'/template/footer.php'; ?>