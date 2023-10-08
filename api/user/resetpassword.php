<?php

require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';

$token = $_POST['token'];

$user = new User();
$succ = $user->getUserByResetToken($token);

if ($succ) {
    $user->resetpassword($_POST['password'], $token);
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid token.']);
}
