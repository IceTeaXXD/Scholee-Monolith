<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/Scholarship.php';
require_once '../../config/config.php';

$scholarship = new Scholarship();

                                
$succ = $scholarship->addScholarship($_POST['user_id'], $_POST['scholarship_id'], $_POST['title'], $_POST['description'],
$_POST['coverage'], $_POST['contact_name'], $_POST['contact_email']);

if($succ){
    echo "Berhasil";
}else{
    echo "Gagal";
}

$data = $scholarship->getAllScholarship();

echo json_encode($data);