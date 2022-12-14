<?php
$_title = 'Home';
require_once __DIR__.'/template/header.php';
$student = new Students();
$a = $student->profilePage();
// $d = $student->delProfile();

//convert age from date
$dob = new DateTime($a[0]->dob);
$today   = new DateTime('today');
$year = $dob->diff($today)->y;


?>

<div class="main-content">
    <div class="container mt-7">
        <!-- Table -->
        <h2 class="mb-5">Welcome <?php echo $a[0]->name; ?></h2>
        <div class="row">
            <div class="col-xl-8 m-auto order-xl-2 mb-5 mb-xl-0">
                <div class="card card-profile shadow">
                    <div class="row justify-content-center">
                        <div class="col-lg-3 order-lg-2">
                            <div class="card-profile-image">

                                <a href="./change-picture.php">
                                    <img src="images/profile_pictures/<?php echo $a[0]->picture; ?>" class="rounded-circle">
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-header text-center border-0 pt-8 pt-md-4 pb-0 pb-md-4">
                        <div class="d-flex justify-content-between">
                            <a type="button" onclick="window.location='update-profile.php';" class="btn btn-sm btn-info mr-4">Edit Profile</a>
                            <input type="submit" name='del' class="btn btn-sm btn-danger float-right" value="'Delete Profile'<?php //echo $student->delProfile() ?>" onclick="return confirm('Are you sure you want to delete your account permanently?');"/>
                            <!-- <button type="button" class="btn btn-sm btn-danger float-right" data-toggle="modal" data-target="#exampleModalLong"> 
                                Delete Profile
                            </button> -->
                            
                    </div>
                    <div class="card-body pt-0 pt-md-4">
                        <div class="row">
                            <div class="col">
                                <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                    <div>
                                        <span class="heading"><?php echo(rand(1,5000));?></span>
                                        <span class="description">Friends</span>
                                    </div>
                                    <div>
                                        <span class="heading"><?php echo(rand(1,50));?></span>
                                        <span class="description">Photos</span>
                                    </div>
                                    <div>
                                        <span class="heading"><?php echo(rand(1,200));?></span>
                                        <span class="description">Comments</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <h3>
                                <?php echo $a[0]->name ?>
                                <span class="font-weight-light"></span>
                            </h3>
                            <h5><span class="font-weight-light">Age: </span><?php echo $year ?></h5>
                            <div class="h5 font-weight-300">
                                <i class="ni location_pin mr-2"></i><?php echo $a[0]->address ?>
                            </div>
                            <div class="h5 mt-4">
                                <i class="ni business_briefcase-24 mr-2"></i><?php echo $a[0]->faculty ?>
                            </div>
                            <div>
                                <i class="ni education_hat mr-2"></i><?php echo $a[0]->school ?>
                            </div>
                            <hr class="my-4">
                            <p><?php echo $a[0]->about ?></p>
                            <a href="https://www.wikipedia.org" target="_blank">Show more</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Delete Profile</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="form-group">
            <label for="password">Enter password to delete your profile.</label>
            <input name="password" type="password" class="form-control" id="password" placeholder="Enter Password">
          </div>
      </div>
      <div class="modal-footer">
        <form action="del-p.php" method="POST">
        <input type="button" class="btn btn-sm btn-secondary mr-4" data-dismiss="modal" value="Close">
        <input type='hidden' name='password' value='<?php echo $student->id; ?>'>
        <input class="btn btn-sm btn-danger mr-4" type='submit' name='delete-profile' value='Delete Profile'>
        <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-danger">Delete</button> -->
        </form>
      </div>
    </div>
  </div>
</div>




<?php include('template/footer.php'); ?>