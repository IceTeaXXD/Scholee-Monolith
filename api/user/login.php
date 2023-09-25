<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';

$user = new User();
if($user->login($_POST['username'],$_POST['password'])){
    session_start();
    $_SESSION['user_id'] = $user->getID();
    $_SESSION['username'] = $user->getName();
    $_SESSION['role'] = $user->getRole();
    $_SESSION['email'] = $user -> getEmail();
    header("Location: /dashboard");
}else{
    header("Location: /login?error=login gagal");
}
