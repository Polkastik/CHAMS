<?php
session_start();
require_once '../Config/auth.php';
require_once '../Config/queryHandler.php';

$q = new QueryHandler();
$response = ['success' => false, 'message' => ''];

if ($_SESSION['role'] <= 2) {
    
    $ticket_id = $_POST['ticket_id'] ?? null;
    $staff_id  = $_POST['staff_id'] ?? null;

    if ($ticket_id && $staff_id) {
        $result = $q->assignTicket($ticket_id, $staff_id);
        
        if ($result) {
            $q->logAction($_SESSION['user_id'], "Assigned ticket #$ticket_id to staff #$staff_id");
            $response['success'] = true;
        } else {
            $response['message'] = "Database update failed.";
        }
    } else {
        $response['message'] = "Missing ticket or staff information.";
    }
} else {
    $response['message'] = "Permission denied. Only MISD personnel can assign tickets.";
}

echo json_encode($response);