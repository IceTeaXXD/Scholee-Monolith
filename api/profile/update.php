<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../app/models/Student.php';
require_once '../../config/config.php';

session_start();

$user = new User();
$student = new Student();

$target = "../../public/image/profiles/";
$filename = time() . '_' .$_FILES['profilepic']['name'];
$target_file = $target. $filename;

$value = array(
    "user_id" => $_SESSION['user_id'],
    "name" => $_POST['name'],
    "level" => $_POST['level'],
    "street" => $_POST['street'],
    "email" => $_SESSION['email'],
    "major" => $_POST['major'],
    "city" => $_POST['city'],
    "zipcode" => $_POST['zipcode'],
    "university" => $_POST['university'],
    "image" => $filename
);

if($_FILES['profilepic']['name'] == ''){
    $value['image'] = '';
}else{
    move_uploaded_file($_FILES['profilepic']['tmp_name'], $target_file);
}

$user -> update($value);
$student -> update($value);


header("Location: /profile");