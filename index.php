<?php
include "./includes/autoload.php";

$admin = new admin();
$data = $admin->getStudents();
echo '<pre>';
print_r($data);
