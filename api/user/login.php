<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';

$user = new User();
$succ = $user->login($_POST['email'],$_POST['password']);
if($succ){
    session_start();
    if ($user->getIsVerified() == 0) {
        echo json_encode(['status' => 'error', 'message' => 'Your account is not verified, please check your email or contact administrator']);
        exit;
    }
    $_SESSION['user_id'] = $user->getID();
    $_SESSION['username'] = $user->getName();
    $_SESSION['role'] = $user->getRole();
    $_SESSION['email'] = $user->getEmail();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incorrect username or password']);
}
