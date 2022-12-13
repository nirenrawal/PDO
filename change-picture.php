<?php
$_title = 'Change Picture';
require_once __DIR__ . '/template/header.php';

$student = new Students();
?>

<section class="pt-5">
    <div class="row">
        <div class="container">
            <form action='<?php $student->uploadPicture() ?>' method='post' enctype="multipart/form-data">

                <input type='hidden' name='id' value='<?php echo $student->id; ?>'>
                <div class="form-group">
                    <label for="picture">Profile Picture</label>
                    <input name="picture" type="file" class="form-control" id="picture" required><br>
                    <input class="btn btn-primary btn-lg" type="submit" value="Upload" />
                </div>
            </form>
        </div>
    </div>
</section>

<?php
require_once __DIR__ . '/template/footer.php';
?>