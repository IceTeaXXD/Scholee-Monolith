<?php
require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../config/config.php';

$db = new Database();
$query = "SELECT
uni.university_id,
uni.name AS university_name,
u.name AS applicant_name,
u.email AS applicant_email,
counts.applicant_count
FROM
university uni
INNER JOIN student s ON uni.university_id = s.university_id
INNER JOIN user u ON s.user_id = u.user_id
INNER JOIN (
    SELECT
        university_id,
        COUNT(*) AS applicant_count
    FROM
        student
    GROUP BY
        university_id
) counts ON uni.university_id = counts.university_id";

$query1 = "SELECT count(*) AS count FROM
university uni
INNER JOIN student s ON uni.university_id = s.university_id
INNER JOIN user u ON s.user_id = u.user_id
INNER JOIN (
    SELECT
        university_id,
        COUNT(*) AS applicant_count
    FROM
        student
    GROUP BY
        university_id
) counts ON uni.university_id = counts.university_id";


$whereClauses = [];
$params = [];
$params1 = [];
$types = "";
$types1 = "";

if(isset($_GET["uid"]) && $_GET['uid'] != NULL){
    $whereClauses[] = " uni.university_id = ? ";
    $params[] = $_GET['uid'];
    $params1[] = $_GET['uid'];
    $types .= 'i';
    $types1 .= "i";
}

if(isset($_GET["name"]) && ($_GET['name'] != NULL || $_GET['name'] != "undefined") ){
    $whereClauses[] = ' u.name LIKE ? ';
    $params[] = "%".$_GET['name']."%";
    $types .= 's';
    $params1[] = "%".$_GET['name']."%";
    $types1 .= 's';
}

if($whereClauses != NULL){
    $query .= ' WHERE '.implode(" AND ", $whereClauses);
    $query1 .= ' WHERE '.implode(" AND ", $whereClauses);
}

if(isset($_GET["currentpage"]) && $_GET["currentpage"] != NULL){
    $query .= "LIMIT ? OFFSET ?";
    $offset = ($_GET['currentpage'] - 1) * $_GET['itemsperpage'];
    $types .= "ii";
    $params[] = $_GET['itemsperpage'];
    $params[] = $offset;
}

$stmt = $db->setSTMT($query);
if($types != ''){
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
$result = mysqli_stmt_execute($stmt);
$row = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

$stmt1 = $db->setSTMT($query1);
if($types != ''){
    mysqli_stmt_bind_param($stmt1, $types1, ...$params1);
}
$result = mysqli_stmt_execute($stmt1);
$total = mysqli_fetch_all(mysqli_stmt_get_result($stmt1), MYSQLI_ASSOC);

$response = [
    'data' => $row,
    'currentPage' => isset($_GET["currentpage"])?$_GET["currentpage"] : 0,
    'total' => $total[0]["count"],
];

echo json_encode($response);
?>