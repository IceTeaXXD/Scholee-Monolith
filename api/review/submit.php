<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/review.php';
require_once '../../config/config.php';

session_start();

$model = new Review;

if (!isset($_SESSION['user_id'])) {
    die(json_encode(['status' => 'error', 'message' => 'User session not found.']));
}

if($_SERVER['REQUEST_METHOD'] === 'POST')
    if($model->submitForReview($_POST['uid'], $_POST['fid'])){
        echo json_encode(['status' => 'success']);
    }else{
        echo json_encode(['status' => 'error', 'message' => 'User session not found.']);
    }

?>