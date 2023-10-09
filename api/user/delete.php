<?php
    require_once '../../app/core/App.php';
    require_once '../../app/core/Database.php';
    require_once '../../app/models/user.php';
    require_once '../../app/models/superadmin.php';
    require_once '../../config/config.php';

    $model = new Superadmin;

    $exec = $model->deleteUser($_POST['user_id']);

    if($exec){
        echo json_encode(['status' => 'success']);
    }else{
        echo json_encode(['status' => 'error', 'message' => 'deletion failed']);
    }
?>