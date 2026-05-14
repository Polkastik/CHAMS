<?php
session_start();
require_once 'auth.php';
require_once 'db.php';
require_once 'queryHandler.php';

$q = new QueryHandler();

$adminId = $_SESSION['user_id'] ?? null;

if ($_POST['action'] === 'deduct' && $adminId) {
    $itemId = $_POST['item_id'];
    $qty = $_POST['qty'];
    $deptId = $_POST['d_id'];

    $result = $q->deductInventory($itemId, $qty, $deptId, $adminId);
    $q->logActivity($adminId, "Deducted Item # $itemId", $itemId, 'Inventory');

    if ($result) {
        echo "success";
    } else {
        echo "Database failed to update.";
    }
} else {
    echo "No valid action received.";
}
exit;