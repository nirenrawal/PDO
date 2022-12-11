<?php
require_once('template/header.php');

$student = new Students();
?>

<form action='<?php $student->uploadPicture() ?>' method='post' enctype="multipart/form-data">

    <input type='hidden' name='id' value='<?php echo $student->id; ?>'>
    <div class="form-group">
        <label for="picture">Profile Picture</label>
        <input name="picture" type="file" class="form-control" id="picture" required>
        <input type="submit" value="Upload" />
    </div>
</form>