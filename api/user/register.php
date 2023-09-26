<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Student.php';
require_once '../../config/config.php';

$student = new Student();
$succ = $student->register($_POST['name'], "student", $_POST['email'], $_POST['password']);

if ($succ === true) {
    header("Location: ../../login");
} else {
    // return to register with errors and show error message
    header('Location: /register/error');
}