<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Student.php';
require_once '../../app/models/Administrator.php';
require_once '../../app/models/Reviewer.php';
require_once '../../config/config.php';

session_start();

if(!isset($_SESSION['role'])){
    $student = new Student();
    $succ = $student->register($_POST['name'], "student", $_POST['email'], $_POST['password']);

    if ($succ === true) {
        header("Location: ../../login");
    } else {
        // return to register with errors and show error message
        header('Location: /register/error');
    }
}else{
    $succ;
    if($_POST['role'] == 'student'){
        $student = new Student();
        $succ = $student->register($_POST['name'], $_POST['role'], $_POST['email'], $_POST['password']);
    }else if($_POST['role']=='admin'){
        $admin = new Administrator();
        $succ = $admin->register($_POST['name'], $_POST['role'], $_POST['email'], $_POST['password']);
    }else if ($_POST['role'] == 'reviewer'){
        $reviewer = new Reviewer();
        $succ = $reviewer->register($_POST['name'], $_POST['role'], $_POST['email'], $_POST['password']);
    }

    if($succ){
        header("Location: /admin/list");
    }
}