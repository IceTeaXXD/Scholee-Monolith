<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../config/config.php';
require_once '../../app/models/SOAP.php';

session_start();
if (!isset($_SESSION['role'], $_SESSION['user_id'])) {
    $response['status'] = 'error';
    $response['message'] = 'You are not logged in.';
    echo json_encode($response);
    exit;
}

$database = new Database();

$query = "SELECT count(*) as count FROM university";
$stmt = $database->setSTMT($query);

mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($res);
$countUni = 0;
$countUni = $row['count'] + 1;

$query = "INSERT INTO university (university_id, name) VALUES (?,?)";
$stmt = $database->setSTMT($query);

mysqli_stmt_bind_param($stmt,"is",$countUni, $_POST['university']);

$res = mysqli_stmt_execute($stmt);

/* Also Create to SOAP */
// $soapClient = new SOAP("");

if($res){
    echo json_encode(array('status'=> 'success','message'=> 'Berhasil menambahkan universitas'));
}else{
    echo json_encode(array('status'=> 'error','message'=> 'Gagal menambahkan universitas'));
}

?>