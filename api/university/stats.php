<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../config/config.php';

$db = new Database();
$query = "SELECT university_id, name, count(*) as count FROM university NATURAL JOIN student GROUP BY university_id";
$stmt = $db->setSTMT($query);
$result = mysqli_stmt_execute($stmt);
$row = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

echo json_encode($row);
?>