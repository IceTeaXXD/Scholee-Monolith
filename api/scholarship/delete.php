<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Scholarship.php';
require_once '../../config/config.php';

$model = new Scholarship;

$exec = $model->deleteScholarship($_SESSION['user_id'],$_GET['scholarship_id']);

header("Location: /scholarships");
?>