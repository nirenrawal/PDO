<?php
$_title = 'Home';
require_once __DIR__ . '/template/header.php';
$student = new Students();
$a = $student->profilePage();


//convert age from date of birth
$dob = new DateTime($a[0]->dob);
$today   = new DateTime('today');
$year = $dob->diff($today)->y;
?>

<div class="main-content">
    <div class="container mt-7">
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

                            <form action='<?php $student->delete() ?>' method='post'>
                                <input type='hidden' name='id' value='<?php echo $a[0]->id; ?>'>
                                <input class="btn btn-sm btn-danger float-right" type='submit' name='delete' value='Delete Profile' onclick="return confirm('Are you sure, you want to delete your profile?');">
                            </form>

                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="row">
                                <div class="col">
                                    <div class="card-profile-stats d-flex justify-content-center mt-md-5">
                                        <div>
                                            <span class="heading"><?php echo (rand(1, 200)); ?></span>
                                            <span class="description">Friends</span>
                                        </div>
                                        <div>
                                            <span class="heading"><?php echo (rand(1, 50)); ?></span>
                                            <span class="description">Photos</span>
                                        </div>
                                        <div>
                                            <span class="heading"><?php echo (rand(1, 200)); ?></span>
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




    <?php require_once __DIR__ . '/template/footer.php'; ?>