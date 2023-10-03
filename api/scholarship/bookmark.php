<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Bookmark.php';
require_once '../../config/config.php';

session_start();
header('Content-Type: application/json');

$model = new Bookmark;
$prio = 1;
if ($model->newBookMark($_SESSION['user_id'], $_POST['uis'], $_POST['sid'], $prio)) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Bookmark creation failed']);
}
?>