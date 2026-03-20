<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once 'queryHandler.php';
require_once 'config.php';
require '../Lib/PHPMailer/Exception.php';
require '../Lib/PHPMailer/PHPMailer.php';
require '../Lib/PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['employee_id'])) {
    
    $q = new QueryHandler();
    $employeeId = htmlspecialchars($_POST['employee_id']);

    $userData = $q->getUserByEmpId($employeeId); 

    if ($userData && !empty($userData['email'])) {
        $userEmail = $userData['email'];
        $fullName = ($userData['FN'] . " " . $userData['LN']);
        
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = SMTP_PORT;

            $mail->setFrom(SMTP_USER, 'CHAMS Security');
            $mail->addAddress($userEmail); 

            $mail->isHTML(true);
            $mail->Subject = "CHAMS - Password Reset Request";
            $mail->Body = "
                <div style='font-family: sans-serif; border: 1px solid #ddd; padding: 20px; border-radius: 10px;'>
                    <h2 style='color: #0b4a7a;'>🔐 Security Verification</h2>
                    <p>Hello <b>$fullName</b>,</p>
                    <p>A password reset test was triggered for Employee ID: <b>$employeeId</b>.</p>
                    <div style='background: #f4f4f4; padding: 15px; border-left: 5px solid #0b4a7a; font-family: monospace;'>
                        Value: reset password test
                    </div>
                    <br>
                    <p>If this is NOT you. Please ignore this email.</p>
                    <p>This email tests the forget password and confirms that your account is linked correctly to the CHAMS-MISD SMTP relay.</p>
                    <hr>
                    <small style='color: #888;'>Sent automatically by CHAMS MISD System</small>
                </div>
            ";

            $mail->send();
            ob_clean();
            echo 'success';
            exit;

        } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
    } else {
        echo "error: Employee ID not found or no email registered.";
    }
} else {
    echo "invalid_request";
}