<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../config/config.php';

session_start();

$user = new User();

if (isset($_GET['userid'])) {
  $user_id = $_GET['userid'];
  $exec = $user->getUserById($user_id);
  if (!$exec) {
    echo json_encode(array("error" => "No user found"));
    exit();
  }
  $name = $user->getName();
  $email = $user->getEmail();
  echo json_encode(array("name" => $name, "email" => $email));
} else {
  echo json_encode(array("error" => "No user id provided"));
}
