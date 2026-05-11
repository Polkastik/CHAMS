<?php
session_start();
require_once '../Config/db.php';
require_once '../Config/queryHandler.php';

$db = new database();
$db->connect();

$q = new QueryHandler();

$ticketNum = $_GET['tnum'] ?? '';

if (!empty($ticketNum)) {
    
    $password = $_POST['confirm_password'] ?? '';
    $admin = $q->getUserByEmpId($_SESSION['user_id']);

    if (!$admin || !password_verify($password, $admin['pass_hash'])) {
        header("Location: ../Flow/dashboard.php?error=wrong_password");
        exit;
    }

    $success = $q->deleteTicketByNum($ticketNum);
    
    if ($success) {
        header("Location: ../Flow/dashboard.php");
    }
}