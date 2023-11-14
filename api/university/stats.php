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

$stmt = $db->setSTMT($query);
$result = mysqli_stmt_execute($stmt);
$row = mysqli_fetch_all(mysqli_stmt_get_result($stmt), MYSQLI_ASSOC);

echo json_encode($row);
?>