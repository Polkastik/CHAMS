<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();
require_once dirname(__DIR__) . '/Config/auth.php';
require_once dirname(__DIR__) . '/Config/queryHandler.php';
require_once dirname(__DIR__) . '/Config/config.php';
require dirname(__DIR__) . '/Lib/PHPMailer/Exception.php';
require dirname(__DIR__) . '/Lib/PHPMailer/PHPMailer.php';
require dirname(__DIR__) . '/Lib/PHPMailer/SMTP.php';


// Only proceed if there is actually a bug report in the POST data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bug_report'])) {

    if (ob_get_length()) ob_clean();
    header('Content-Type: text/plain');

    // Quick session integrity fallback check
    if (!isset($_SESSION['user_id'])) {
        echo "error: User session lost.";
        exit;
    }
    
    $q = new QueryHandler();

    $bugDescription = htmlspecialchars($_POST['bug_report']);
    $userData = $q->getUserById($_SESSION['user_id']);

    if ($userData) {
        $fullName = $userData['full_name'] ?? ($userData['FN'] . " " . $userData['LN']);
        $userId = $userData['employee_ID'];

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = SMTP_PORT;

            // Recipients - Use the constant here too for a cleaner look!
            $mail->setFrom(SMTP_USER, 'CHAMS Bug Reporter');
            $mail->addAddress(SMTP_USER);

            $mail->isHTML(true);
            $mail->Subject = "CHAMS Bug Report from $fullName";
            $mail->Body = "
                <div style='font-family: sans-serif; border: 1px solid #ddd; padding: 20px;'>
                    <h2 style='color: #d9534f;'>🐞 New Bug Report</h2>
                    <p><strong>Reported By:</strong> $fullName ($userId)</p>
                    <p><strong>Description:</strong></p>
                    <div style='background: #f9f9f9; padding: 15px; border-left: 5px solid #d9534f;'>
                        " . nl2br($bugDescription) . "
                    </div>
                    <br>
                    <hr>
                    <small style='color: #888;'>Sent automatically from CHAMS-MISD System</small>
                </div>
            ";
            
            $mail->SMTPDebug =2;

            $mail->send();
            echo 'success';

        } catch (Exception $e) {
            echo "error: Mailer Error - " . $mail->ErrorInfo;
        }
    } else {
        echo "error: User session lost.";
    }
} else {
    echo "invalid_request";
}