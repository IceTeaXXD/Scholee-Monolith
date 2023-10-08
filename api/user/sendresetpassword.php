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
require_once '../../config/config.php';

$email = $_POST['email'];

// Create reset token
$token = bin2hex(random_bytes(16));

$user = new User();
$succ = $user->getUserByEmail($email);

if ($succ) {
    // Mail the token
    $user->createresettoken($email, $token);
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
        $mail->Subject = 'Scholee Password Reset';
        $mail->Body = <<<END

        <p>Hi,</p>
        <p>We received a request to reset your password. If you did not make this request, please ignore this email.</p>
        <p>Otherwise, please click the link below to reset your password.</p>
        <p><a href="http://localhost:3000/resetpassword?token=$token">Reset Password</a></p>
        <p>Thank you.</p>
        END;

        $mail->send();
    
        echo json_encode(['status' => 'success', 'message' => 'Email sent. Check your inbox.']);
    } catch (Exception $e) {
        echo json_encode(['status' => 'error', 'message' => $mail->ErrorInfo]);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'User does not exist.']);
}