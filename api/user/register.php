<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

require_once '../../app/core/App.php';
require_once '../../app/core/Database.php';
require_once '../../app/models/User.php';
require_once '../../app/models/Student.php';
require_once '../../app/models/Administrator.php';
require_once '../../app/models/Reviewer.php';
require_once '../../config/config.php';

session_start();

if (!isset($_SESSION['role'])) {
    $student = new Student();
    $token = bin2hex(random_bytes(16));
    $succ = $student->register($_POST['name'], "student", $_POST['email'], $_POST['password'], $token, $_POST['university']);
    if ($succ === true) {
        $email = $_POST['email'];
        $name = $_POST['name'];
        $mail = new PHPMailer(true);
        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'scholeeedu@gmail.com';
            $mail->Password   = 'pnpaxnrwarupnojb';
            $mail->SMTPSecure = 'ssl';
            $mail->Port       = 465;
        
            //Recipients
            $mail->setFrom('scholeeedu@gmail.com');
            $mail->addAddress($email);
        
            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Scholee Account Verification';
            $mail->Body = <<<END
    
            <p>Hi, $name</p>
            <p>Thank you for registering. Please click the link below to verify your account.</p>
            <p><a href="http://localhost:3000/verify?token=$token">Verify Account</a></p>
            <p>Thank you.</p>
            END;
    
            $mail->send();
        
            echo json_encode(['status' => 'success', 'message' => 'Email sent. Check your inbox.']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User already exists.']);
    }
} else {
    $succ;
    if ($_POST['role'] == 'student') {
        $token = bin2hex(random_bytes(16));
        $student = new Student();
        $succ = $student->register($_POST['name'], $_POST['role'], $_POST['email'], $_POST['password'], $token, $_POST['uni_id']);
    } else if ($_POST['role'] == 'admin') {
        $admin = new Administrator();
        $succ = $admin->register($_POST['name'], $_POST['role'], $_POST['email'], $_POST['password'], '');
    } else if ($_POST['role'] == 'reviewer'){
        $reviewer = new Reviewer();
        $succ = $reviewer->register($_POST['name'], $_POST['role'], $_POST['email'], $_POST['password'], '');
    }

    if ($succ) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User already exists.']);
    }
}
