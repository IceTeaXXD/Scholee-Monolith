<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Bookmark.php';
require_once '../../config/config.php';

session_start();

$model = new Bookmark;

if($model->deleteUserBookmark($_SESSION['user_id'], $_POST['uis'], $_POST['sid'])){
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Bookmark deletion failed']);
}
?>