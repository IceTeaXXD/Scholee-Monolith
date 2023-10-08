<?php 
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';


$user = new User();

if (isset($_POST['user_id'])) {
    $succ = $user->verify($_POST['user_id']);
    if ($succ) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User does not exist.']);
    }
}

if (isset($_POST['token'])) {
    $succ = $user->getUserByVerifyToken($_POST['token']);
    if ($succ) {
        $succ = $user->verifyToken($_POST['token']);
        if ($succ) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Unknown error occured.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid token.']);
    }
}