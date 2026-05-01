<?php
session_start();
require_once 'queryHandler.php';

if (ob_get_length()) ob_clean();

if (!isset($_SESSION['user_id'])) {
    exit("Unauthorized");
}

$q = new QueryHandler();
$userId = $_SESSION['user_id']; 

if (isset($_POST['scope']) && $_POST['scope'] === 'all') {
    $success = $q->markAllNotifsRead($userId); 
    echo $success ? "success" : "fail";
    exit;
}

if (!isset($_POST['notif_id'])) {
    exit("No notification ID");
}

$notifId = $_POST['notif_id'];
$success = $q->dismissNotification($notifId, $userId);

echo "success";
exit;