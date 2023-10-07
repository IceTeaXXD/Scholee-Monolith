<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';

$user = new User();
if($user->login($_POST['email'],$_POST['password'])){
    session_start();
    $_SESSION['user_id'] = $user->getID();
    $_SESSION['username'] = $user->getName();
    $_SESSION['role'] = $user->getRole();
    $_SESSION['email'] = $user->getEmail();
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Incorrect username or password']);
}
