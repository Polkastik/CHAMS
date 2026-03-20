<?php
session_start();
ob_clean();
require_once 'queryHandler.php';
$q = new QueryHandler();
$userId = $_SESSION['user_id'];

$action = $_POST['action'] ?? '';

if ($action === 'update_name') {
    $fn = $_POST['fn'];
    $ln = $_POST['ln'];

    if ($q->updateUserName($userId, $fn, $ln)) {
        $_SESSION['fname'] = $fn;
        $_SESSION['lname'] = $ln;
        echo "success";
        exit;
    }
}

if ($action === 'update_pass') {
    $curr = $_POST['curr'];
    $next = $_POST['next'];
    
    $user = $q->getUserById($userId); 
    
    if ($user && password_verify($curr, $user['pass_hash'])) {
        $newHash = password_hash($next, PASSWORD_DEFAULT);
        if ($q->updateUserPassword($userId, $newHash)) {
            echo "success";
            exit;
        } else {
            echo "Database error during save.";
            exit;
        }
    } else {
        echo "Current password incorrect.";
        exit;
    }
}