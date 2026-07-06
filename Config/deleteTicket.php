<?php
ini_set('display_errors', 1);
ini_set('display_errors', 'On');
error_reporting(E_ALL);
session_start();
require_once '../Config/db.php';
require_once '../Config/queryHandler.php';

$db = new database();
$db->connect();
$q = new QueryHandler();

$ticketNum = $_POST['tnum'] ?? '';
$id = $_POST['id'] ?? '';

if (!empty($ticketNum)) {
    
    $password = $_POST['confirm_password'] ?? '';
    $admin = $q->getUserById($_SESSION['user_id']);

    if (!$admin || !password_verify($password, $admin['pass_hash'])) {
        header("Location: ../Flow/tileView.php?id=$id&mode=ticketing&edit=true&error=wrong_password");
        exit;
    }

    $success = $q->deleteTicketByNum($ticketNum);
    
    if ($success) {
        $q->logActivity(
            $_SESSION['user_id'], 
            "Deleted Ticket: #$ticketNum", 
            $ticketNum, 
            'Ticketing'
        );
        header("Location: ../Flow/ticket.php?msg=deleted");
        exit;
    } else {
        header("Location: ../Flow/tileView.php?id=$id&mode=ticketing&edit=true&error=delete_failed");
        exit;
    }
} else {
    header("Location: ../Flow/ticket.php?error=missing_id");
    exit;
}