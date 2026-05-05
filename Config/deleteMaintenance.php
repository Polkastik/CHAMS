<?php
session_start();

require_once 'db.php';
require_once 'queryHandler.php';

$db = new database();
$db->connect();

$q = new QueryHandler();

$id = $_GET['id'] ?? null;

if (!empty($id)) {

    $success = $q->deleteMaintenanceById($id);

    if ($success) {

        // optional logging
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $q->logActivity($userId, "Deleted Maintenance #$id", $id, "Maintenance");
        }

        header("Location: ../Flow/maintenanceLog.php?success=deleted");
        exit;

    } else {
        header("Location: ../Flow/maintenanceLog.php?error=delete_failed");
        exit;
    }

} else {
    header("Location: ../Flow/maintenanceLog.php?error=invalid_id");
    exit;
}