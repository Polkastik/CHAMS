<?php
require_once '../Config/db.php';
require_once '../Config/queryHandler.php';

$db = new database();
$db->connect();

$qh = new QueryHandler();

$ticketNum = $_GET['tnum'] ?? '';

if (!empty($ticketNum)) {
    // Update your QueryHandler to have a deleteByNum method
    $success = $qh->deleteTicketByNum($ticketNum);
    
    if ($success) {
        header("Location: ../Flow/dashboard.php");
    }
}