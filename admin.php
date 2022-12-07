<?php
include('template/header.php');

$admin = new Admin();
$students = $admin->getStudents();
$del_students = $admin->delete();


?>

<h1 class="text-center pt-3 pb-2">List of the Users</h1>
<table class="table">
  <thead>
    <tr>
      <th scope="col">Sn</th>
      <th scope="col">ID</th>
      <th scope="col">Full Name</th>
      <th scope="col">DOB</th>
      <th scope="col">Address</th>
      <th scope="col">Reg. Time & Date</th>
      <th scope="col">School</th>
      <th scope="col">Email</th>
      <th scope="col">Photo</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    <?php
    $number = 1;
    foreach ($students as $student) {


    ?>
      <tr>
        <th scope="row">
          <?php echo $number;
          $number++;  ?>
        </th>
        <th scope="row">
          <?php echo $student->id; ?>
        </th>
        <td>
          <?php echo $student->name; ?>
        </td>
        <td>
          <?php echo $student->dob; ?>
        </td>
        <td>
          <?php echo $student->address; ?>
        </td>
        <td>
        <?php echo $student->time." ".$student->date;?>
        </td>
        <td>
          <?php echo $student->school; ?>
        </td>
        <td>
          <?php echo $student->email; ?>
        </td>
        <td>
        <img src="images/profile_pictures/<?php echo $student->picture; ?>" width="50" height="50">
        </td>
        <td>
        <a href="$del_students?id=<?php echo $student->id;?>" onclick="return confirm('Are you sure?');" type="button" onclick="window.location='admin.php.php';" class="btn btn-sm btn-danger mr-4">Delete</a>
        </td>
      </tr>
    <?php
    }
    ?>

  </tbody>
</table>

<?php
require_once('template/footer.php');
?>