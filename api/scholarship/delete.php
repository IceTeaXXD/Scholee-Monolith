<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Scholarship.php';
require_once '../../config/config.php';

session_start();

$model = new Scholarship($_SESSION['role'], $_SESSION['user_id']);

$exec = $model->deleteScholarship($_POST['uid'],$_POST['sid']);

if($exec){
    echo json_encode(['status' => 'success']);
}
?>