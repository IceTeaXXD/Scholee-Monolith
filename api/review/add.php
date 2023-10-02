<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/review.php';
require_once '../../config/config.php';

session_start();

$target = "../../public/files/";
$filename = time() . '_' .$_FILES['document']['name'];
$file_info = pathinfo($filename);
$file_extension = $file_info['extension'];
$target_file = $target. $filename;

$model = new Review();

move_uploaded_file($_FILES['document']['tmp_name'], $target_file);

$model->addStudentDocument($file_extension, $filename);

header("Location: /reviews");
?>